<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        
       
        // Do something here

        return response()->json(['message' => 'Webhook received'], 200);
    }
}
