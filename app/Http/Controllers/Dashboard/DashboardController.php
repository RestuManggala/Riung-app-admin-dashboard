<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Dashboard.dashboard', [
            "tittle" => "Dashboard",
            "username" => Auth::user()->name,
        ]);
    }
}
