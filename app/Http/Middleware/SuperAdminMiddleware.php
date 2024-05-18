<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $refreshTokenApi = $this->loginJubelio($request);

        if(auth()->user()->role_id == 1){
            return $next($request);
        }

        return redirect('login')->with('error',"You don't have super admin access.");
    }

    public function loginJubelio(Request $request){
        $userData = auth()->user();
        $users =  User::find($userData->id)->first();
        $loginUser =  Http::post(env('JUBELIO_API') . '/login', [
            'email' => env('JUBELIO_EMAIL'),
            'password' => env('JUBELIO_PASSWORD')
        ]);

        if($loginUser->status() == 200){
            // try auth login
            $userLogin = $loginUser->json();
            // set new token
            $users->api_token = $userLogin['token'];
        } 
        $users->save();
    }
}
