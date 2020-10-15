<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DiscountCode extends Model {
    use SoftDeletes;

    protected $table = "discount_codes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discounted_by', 'discounted_to', 'status', 'discounted_on', 'redeemed_on', 'invalidated_on', 'comments', 'redeem_count',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'discounted_on' => 'date',
        'redeemed_on' => 'date',
        'invalidated_on' => 'date',
    ];

    /**
     * Relationship: createdBy
     *	A discount code belongs to a user who creates it(created by - Admin or Subadmin)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(){
    	return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * Relationship: discountedBy
     *	A discount code belongs to a user who discounts it (awards it to a student/parent/FL - Admin or Subadmin)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discountedBy(){
    	return $this->belongsTo('App\User', 'discounted_by');
    }

    /**
     * Relationship: discountedTo
     *	A discount code belongs to a user who redeems it (student/parent/FL)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discountedTo(){
    	return $this->belongsTo('App\User', 'discounted_to');
    }

    /**
     * Relationship: redeemers
     *  A discount code has many redeemers (who redeem it)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function redeemers(){
        return $this->hasMany('App\Models\CodeRedeemer', 'discount_code_id');
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
