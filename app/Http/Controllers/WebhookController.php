<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Closure;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleProduct(Request $request)
    {

        $payload = new \stdClass();
        $payload->action = 'update-product';
        $payload->item_group_id = 1;
        $payload->item_group_name = "Test barang";
        
        // For example, log the payload
        // \Log::info('Webhook payload:', (array) $payload);

        // Return a JSON response with the payload
        return response()->json($payload, 200);
    }
}
