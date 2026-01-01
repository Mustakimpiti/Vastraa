<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // For now, we'll return the view without any data
        // Later you can add products, sliders, etc. from database
        
        return view('pages.home');
    }
}