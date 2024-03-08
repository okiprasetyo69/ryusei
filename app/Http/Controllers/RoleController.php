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

use App\Models\Role;
use App\Services\Interfaces\RoleService;

class RoleController extends Controller
{

    /**
     * @var Role
    */
    
    private RoleService $service;

    public function __construct(RoleService $service) 
    {
        $this->service = $service;
    }

    public function getRole(Request $request){
        try{
            $role = $this->service->getRole($request);

            if($role != null){
                return $role;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
