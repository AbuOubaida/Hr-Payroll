<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\company;

class admindashboardController extends Controller
{

    //
    public function index()
    {
        return view('admin/index');
    }
}
