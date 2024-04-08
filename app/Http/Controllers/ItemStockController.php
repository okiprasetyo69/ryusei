<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemStockController extends Controller
{

    public function index(Request $request){
        return view("warehouse.incoming_items");
    }
}
