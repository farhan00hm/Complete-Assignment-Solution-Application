<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait TransactionTrait {
    function generateSkooliTransactionRef(){
        $random = '';
  		for ($i = 0; $i < 8; $i++) {
    		$random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
  		}
  		return "SK-" . strtoupper($random);
    }

}