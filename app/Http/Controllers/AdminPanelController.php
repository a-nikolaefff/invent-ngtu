<?php

namespace App\Http\Controllers;

class AdminPanelController extends Controller
{
    /**
     * Display admin panel page
     */
    public function index()
    {
        return view('admin-panel');
    }
}
