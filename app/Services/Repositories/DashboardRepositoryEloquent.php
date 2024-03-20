<?php

namespace App\Services\Repositories;

use App\Services\Interfaces\DashboardService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.20
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class CategoryRepositoryEloquent implements DashboardService {

    public function totaPerItemSold(Request $request){
        return true;
    }
 }