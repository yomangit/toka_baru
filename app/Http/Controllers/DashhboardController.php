<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashhboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [])->extends('base.index', ['header' => 'Dashboard', 'title' => 'Dashboard'])->section('content');
    }
}
