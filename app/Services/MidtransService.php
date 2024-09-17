<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        // Set configuration from config/midtrans.php
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction($params)
    {
        try {
            // Call Midtrans Snap API for transaction
            return Snap::createTransaction($params);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
