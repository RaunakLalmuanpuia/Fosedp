<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function create(Request $request)
    {
        return inertia('Backend/Dashboard');
    }
}
