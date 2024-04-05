<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesInvoiceController extends Controller
{
    // WEB
    public function index(Request $request){
        return view("sales_invoice.index");
    }

    public function add(Request $request){
        return view("sales_invoice.add");
    }

    // API Response
}
