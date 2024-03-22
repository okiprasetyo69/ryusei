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
                'email' => 'required|email',
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

            $user = $this->service->create($request);
            if($user){
                return $user;
            }

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // update user
    public function update(Request $request){
        try{
            $user = new User();
            $user->fill($request->all());

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
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

            $user = $this->service->update($request);
            if($user){
                return $user;
            }

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // detail user
    public function detail(Request $request){
        try{
            $user = new User();
            $user->fill($request->all());

            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 422
                ]);
            }

            return $this->service->detail($request);
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $user = new User();
            $user->fill($request->all());

            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 422
                ]);
            }

            return $this->service->delete($request);
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
