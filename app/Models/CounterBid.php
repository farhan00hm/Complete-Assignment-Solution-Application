<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CounterBid extends Model {
    use SoftDeletes;

    protected $table = "counter_bids";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'amount', 'note'
    ];

    /**
     * Relationship: bid
     *	A counter bid belongs to a bid
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bid(){
    	return $this->belongsTo('App\Models\Bid');
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
