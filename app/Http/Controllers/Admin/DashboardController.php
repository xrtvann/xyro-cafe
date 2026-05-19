<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        if ($role === 'owner') {
            return view('admin.dashboard.owner');
        } elseif ($role === 'kasir') {
            return view('admin.dashboard.kasir');
        } else {
            return view('customer.dashboard');
        }
    }
}
