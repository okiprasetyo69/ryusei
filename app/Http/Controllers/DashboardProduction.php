<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardProduction extends Controller
{
     // WEB
    public function index(Request $request){
        return view("dashboard.production.index");
    }
}
