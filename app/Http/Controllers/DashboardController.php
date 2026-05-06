<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        if ($role === 'owner') {
            return view('dashboard.owner');
        } elseif ($role === 'kasir') {
            return view('dashboard.kasir');
        } else {
            return view('dashboard.customer');
        }
    }
}
