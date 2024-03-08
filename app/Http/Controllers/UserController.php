<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Closure;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Services\Interfaces\UserService;


class UserController extends Controller
{   
    /**
     * @var User
    */
    
    private UserService $service;

    public function __construct(UserService $service) 
    {
        $this->service = $service;
    }

    public function index(Request $request){
        return view("user.index");
    }
    // get users data
    public function getUser(Request $request){
        try{
            $user = $this->service->getUser($request);
            if($user != null){
                return $user;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // create user
    public function create(Request $request){
        try{
            $user = new User();
            $user->fill($request->all());

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'phone' => 'required',
                'role_id' => 'required'
            ]);

            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 422
                ]);
            }

            if($this->service->create($request)) {
                $user = User::all();
                return $user;
            }

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
