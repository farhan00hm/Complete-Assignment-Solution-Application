<?php

namespace App\Traits;

use Illuminate\Support\Str;

use App\Models\DiscountCode;

trait DiscountCodeTrait {
    function generateCode(){
        $random = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);
  		return strtoupper($random);
    }

    function validateCode($code){
    	$code = DiscountCode::where('code', $code)->first();

    	if (! $code) {
    		return false;
    	}

    	if ($code->status == "INVALIDATED" || !empty($code->invalidated_on)) {
    		return false;
    	}

    	return true;
    }

    function isRedeemed($code){
    	$code = DiscountCode::where('code', $code)->first();

    	if (! $code) {
    		return false;
    	}

    	if ($code->status == "REDEEMED") {
    		return true;
    	}

    	return false;
    }

}