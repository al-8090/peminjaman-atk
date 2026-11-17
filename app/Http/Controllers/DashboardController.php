<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalEquipmentStock = Equipment::sum('stock');
        $totalEmployees = Employee::count();
        $activeLoans = Loan::where('status', 'dipinjam')->count();
        $returnedLoans = Loan::where('status', 'dikembalikan')->count();

        $recentLoans = Loan::with(['employee', 'items.equipment'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalCategories',
            'totalEquipmentStock',
            'totalEmployees',
            'activeLoans',
            'returnedLoans',
            'recentLoans'
        ));
    }
}
