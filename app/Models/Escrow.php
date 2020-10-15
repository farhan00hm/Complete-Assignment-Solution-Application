<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Escrow extends Model {
    use SoftDeletes;

    protected $table = "escrow";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'disputed', 'comments', 'maturity_date',
    ];

    /**
     * Relationship: homework
     *	An escrow belongs to a homework
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function homework(){
    	return $this->belongsTo('App\Models\Homework', 'homework_id');
    }

    /**
     * Relationship: bid
     *	An escrow belongs to a bid
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bid(){
    	return $this->belongsTo('App\Models\Bid', 'bid_id');
    }

    /**
     * Relationship: transaction
     *	An escrow belongs to a transaction
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction(){
    	return $this->belongsTo('App\Models\Transaction', 'transaction_id');
    }

    /**
     * Relationship: commission
     *  An escrow has zero or one commission
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function commission(){
        return $this->HasOne('App\Models\Commission', 'escrow_id');
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
