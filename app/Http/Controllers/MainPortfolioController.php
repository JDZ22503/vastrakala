<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainPortfolioController extends Controller
{
    public function index()
    {
        return view('portfolio');
    }
}
