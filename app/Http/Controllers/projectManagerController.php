<?php

namespace App\Http\Controllers;

use App\Rules\Html;
use Illuminate\Http\Request;

class projectManagerController extends Controller
{
    private $html = null;
    private $record = 10;
    public function __construct()
    {
        $this->html = new Html;//Rule for check html spatial character
    }
    //
    public function index()
    {
        return view('project-manager/index');
    }
}
