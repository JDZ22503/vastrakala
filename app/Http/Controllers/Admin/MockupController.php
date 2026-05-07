<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MockupController extends Controller
{
    /**
     * Display the Mockup Pro workspace.
     */
    public function index()
    {
        return view('admin.mockups.index');
    }
}
