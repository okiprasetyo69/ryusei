<?php

namespace App\Services\Repositories;

use App\Models\Role;
use App\Services\Interfaces\RoleService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * Class RoleRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.08
 * 
 *
 * @package namespace App\Services\Repositories;
 */

class RoleRepositoryEloquent implements RoleService {
    /**
     * @var Role
     */

    private Role $role;

    public function __construct(Role $role)
    {
         $this->role = $role;
    }

    public function getRole(Request $request){
        try{
            $role = $this->role::all();

            if($role == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }
            return response()->json([
                'data' =>  $role,
                'message' => 'Success get user !',
                'status' => 200
            ]);
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
    }
}