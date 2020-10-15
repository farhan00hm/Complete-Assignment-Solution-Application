<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CodeRedeemer extends Model {
    use SoftDeletes;

    protected $table = "discount_code_redeemers";

    /**
     * Relationship: discountCode
     *	A discount code redeemer belongs to a discount
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discountCode(){
    	return $this->belongsTo('App\Models\DiscountCode', 'discount_code_id');
    }

    /**
     * Relationship: user (redeemer)
     *	A discount code redeemer belongs to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Function: auto ejects uuid for every model created.
     *
     * @return void
    */
    public static function boot(){
        parent::boot();
        self::creating(function ($model){
            $model->uuid = (string) Str::uuid();
        });
    }
}
