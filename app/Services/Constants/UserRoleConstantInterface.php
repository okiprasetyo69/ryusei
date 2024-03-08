<?php 

namespace App\Services\Constants;

/**
 * UserRoleContantsInterface contains base constant for property types.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * 
 * @since 08 March 2024
 */

 interface UserRoleContantsInterface 
 {
     /**
     * Role ID of superadmin.
     */
    const SUPER_ADMIN = 1;

     /**
     * Role ID of admin.
     */
    const ADMIN = 2;

     /**
     * Role ID of finance.
     */
    const FINANCE = 3;

     /**
     * Role ID of marketing.
     */ 
    const MARKETING = 4;

     /**
     * Role ID of accounting.
     */ 
    const ACCOUNTING = 4;

     /**
     * Role ID of warehouse.
     */ 
    const WAREHOUSE = 5;
 }