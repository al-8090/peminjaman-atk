<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Loan;
use App\Models\LoanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with(['employee', 'items.equipment'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('loan_code', 'like', "%{$search}%")
                    ->orWhereHas('employee', function ($emp) use ($search) {
                        $emp->where('name', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%");
                    });
            });
        }

        $loans = $query->paginate(10);
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $employees = Employee::orderBy('name')->get();
        $equipments = Equipment::where('stock', '>', 0)->orderBy('name')->get();
        return view('loans.create', compact('employees', 'equipments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
            'notes' => 'nullable|string',
            'equipment_id' => 'required|array|min:1',
            'equipment_id.*' => 'required|exists:equipment,id',
            'qty' => 'required|array|min:1',
            'qty.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Cek stok masing-masing barang
            foreach ($request->equipment_id as $index => $eqId) {
                $equipment = Equipment::lockForUpdate()->findOrFail($eqId);
                $requestedQty = (int) $request->qty[$index];

                if ($equipment->stock < $requestedQty) {
                    DB::rollBack();
                    return back()->withInput()->withErrors([
                        'stock' => "Stok {$equipment->name} tidak mencukupi (tersisa {$equipment->stock})."
                    ]);
                }
            }

            $loan = Loan::create([
                'loan_code' => 'PJM-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
                'employee_id' => $request->employee_id,
                'loan_date' => $request->loan_date,
                'due_date' => $request->due_date,
                'status' => 'dipinjam',
                'notes' => $request->notes,
            ]);

            foreach ($request->equipment_id as $index => $eqId) {
                $requestedQty = (int) $request->qty[$index];

                LoanItem::create([
                    'loan_id' => $loan->id,
                    'equipment_id' => $eqId,
                    'qty' => $requestedQty,
                ]);

                Equipment::where('id', $eqId)->decrement('stock', $requestedQty);
            }

            DB::commit();
            return redirect()->route('loans.index')->with('success', 'Transaksi peminjaman berhasil dicatat & stok telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    public function show(Loan $loan)
    {
        $loan->load(['employee', 'items.equipment.category']);
        return view('loans.show', compact('loan'));
    }

    public function returnItems(Loan $loan)
    {
        if ($loan->status === 'dikembalikan') {
            return back()->with('error', 'Peminjaman ini sudah dikembalikan sebelumnya.');
        }

        DB::transaction(function () use ($loan) {
            foreach ($loan->items as $item) {
                Equipment::where('id', $item->equipment_id)->increment('stock', $item->qty);
            }

            $loan->update([
                'status' => 'dikembalikan',
                'return_date' => now()->toDateString(),
            ]);
        });

        return redirect()->route('loans.show', $loan)->with('success', 'Peralatan berhasil dikembalikan dan stok telah bertambah kembali.');
    }
}
