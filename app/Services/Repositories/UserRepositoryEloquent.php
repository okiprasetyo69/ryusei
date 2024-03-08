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

           DB::statement( DB::raw( 'set @rownum=0' ));
            $user = $this->user::with('role')->select([
                'users.*',
                DB::raw( '@rownum  := @rownum  + 1 AS rownum' ),
            ]);

            if($user != null){
                $datatables = Datatables::of( $user );
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

    public function delete(Request $request){}

    public function detail(Request $request){}
 }