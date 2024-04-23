<?php 

namespace App\Services\Constants;

/**
 * SalesInvoiceConstantInterface contains base constant for invoice.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * 
 * @since 23 April 2024
 */

 interface SalesInvoiceConstantInterface 
 {
     /**
     * OPEN STATE
     */
    const OPEN = 0;

     /**
     * CLOSE STATE
     */
    const CLOSE = 1;

     /**
     * DRAFT STATE
     */
    const DRAFT = 2;

     /**
     * VOID STATE 
     */ 
    const VOID = 3;

    /**
     * INVOICE ACTIVE
    */ 
    const INVOICE_IS_ACKTIVE = 0;

    /**
     * INVOICE DELETED
    */ 
    const INVOICE_IS_DELETED = 1;
 }