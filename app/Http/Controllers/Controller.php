<?php

namespace FitHabit\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Define stripe keys used within all controllers.
    public $stripePubKey;
    public $stripeSecureKey;

    public function __construct()
    {
    	
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') { // In case of windows server.
		    $this->stripePubKey = "pk_test_gzBKWQ1XzvYovh2Ox7enuC7W";
		    $this->stripeSecureKey = "sk_test_th2NqY6ZybETfOiGhjA3V6bT";
        } else {
		    $this->stripePubKey = "pk_live_DgYMe7qp2ksF8rR06ioIeAkk";
		    $this->stripeSecureKey = "sk_live_MS8y9Uan1lY9tpHQZJMjsKEM";
        }
	}
}