<?php 

namespace App\Services\Constants;

/**
 * DevelopmentConstantInterface contains base constant for development status.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * 
 * @since 23 April 2024
 */

 interface DevelopmentConstantInterface 
 {
    /**
    * PO Status
    */
    const STATUS_PO = 1;

    /**
    * FILM Status
    */
    const STATUS_FILM = 2;

    /**
    * SAMPLING Status
    */
    const STATUS_SAMPLING = 3;

    /**
    * PRODUCTION Status
    */
    const STATUS_PRODUCTION = 4;
 }