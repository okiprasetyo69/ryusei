<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Services\Interfaces\UserService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class UserRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.08
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class UserRepositoryEloquent implements UserService {

    /**
     * @var User
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(Request $request){
        try{
            $user = $this->user::with('role');

            if($request->name != null){
                $user->where("name", "like", "%" . $request->name. "%");
            }

            if($request->email != null ){
                $user->where("email", "like", "%" . $request->email. "%");
            }

            if($request->phone != null ){
                $user->where("phone", "like", "%" . $request->phone. "%");
            }

            if($user != null){
                $datatables = Datatables::of( $user->get() );
                return $datatables->make( true );
            }

            return false;
         }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
    }

    public function create(Request $request){
        try{
            $user = new User();
            $user->fill($request->all());

            if($request->id != null){
                $user = $user::find($request->id);
            }

            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->phone = $request->phone;
            $user->role_id = $request->role_id;

            $user->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $user
            ]); 

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $user = $this->user::where("id", $request->id)->first();
            if($user == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $user->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete user.',
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{

            $user = $this->user::find($request->id);

            if($user == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            return response()->json([
                'data' =>  $user,
                'message' => 'Success get user !',
                'status' => 200
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
    }

    public function update(Request $request){

        try{
            $user = $this->user;
            $user->fill($request->all());

            if($request->id != null){
                $user = $user::find($request->id);
            }
        
            $password = "";
            if($request->password != null){
                $password = bcrypt($request->password);
                $user->password = $password;
            }

            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->role_id = $request->role_id;

            $user->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $user
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
        
    }
    
 }