<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiskusiController extends Controller
{
    public function index()
    {
        return view('page.diskusi');
    }
}
