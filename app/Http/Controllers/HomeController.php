<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Sementara dummy data (bisa diganti query Product)
        $discountProducts    = [];
        $recommendedProducts = [];
        $otherProducts       = [];
        $categories          = [];

        return view('welcome', compact(
            'discountProducts',
            'recommendedProducts',
            'otherProducts',
            'categories'
        ));
    }
}
