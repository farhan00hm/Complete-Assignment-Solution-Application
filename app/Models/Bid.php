<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Bid extends Model {
    use SoftDeletes;

    protected $table = "bids";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'amount'
    ];

    /**
     * Relationship: homework
     *	A bid belongs to a homework
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function homework(){
    	return $this->belongsTo('App\Models\Homework', 'homework_id');
    }

    /**
     * Relationship: bidder
     *	A bid belongs to a user (bidder) - user_type "FL" in users table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bidder(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Relationship: escrow
     *  A bid has zero or one escrow
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function escrow(){
        return $this->HasOne('App\Models\Escrow', 'bid_id');
    }

    /**
     * Relationship: awardedHomework
     *  A bid has zero or one homework that it was awarded
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    /*public function awardedHomework(){
        return $this->HasOne('App\Models\Bid', 'winning_bid_id');
    }*/

    /**
     * Relationship: counterBids
     *  A bid has zero or many counter bids
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function counterBid(){
        return $this->HasOne('App\Models\CounterBid');
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
