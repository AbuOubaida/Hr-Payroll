<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Route;

class DashboardController extends Controller
{
    //For Index
    public function index()
    {
//        return redirect(Auth::user()->roles()->first()->name.'/dashboard');
        if (Auth::user()->hasRole('employee')) {
            return redirect('employee/dashboard');
        } elseif (Auth::user()->hasRole('admin')) {
//            return redirect('admin/dashboard');
            return redirect('admin/dashboard');
        } elseif (Auth::user()->hasRole('project-manager')) {
            return redirect('project-manager/dashboard');
        }
        return view('/');
    }
}
