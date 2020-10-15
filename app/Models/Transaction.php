<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Transaction extends Model {
    use SoftDeletes;

    protected $table = "transactions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_user', 'to_user', 'homework_id', 'status', 'processor_status', 'comments', 'provider_transaction_datetime',
    ];

    /**
     * Relationship: from
     *	A transaction belongs to a user (from user - The user whose wallet is to be debited)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from(){
    	return $this->belongsTo('App\User', 'from_user');
    }

    /**
     * Relationship: to
     *	A transaction belongs to a user (to user - The user whose wallet is to be credited)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to(){
    	return $this->belongsTo('App\User', 'to_user');
    }

    /**
     * Relationship: initiator
     *	A transaction belongs to a user (The user who initiated the transaction - mostly admin withdrawals)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function initiator(){
    	return $this->belongsTo('App\User', 'initiator');
    }

    /**
     * Relationship: homework
     *	A transaction belongs to a homework (IFF the transaction is a pay type)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function homework(){
    	return $this->belongsTo('App\Models\Homework', 'homework_id');
    }

    /**
     * Relationship: escrow
     *  A transaction has zero or one escrow
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function escrow(){
        return $this->HasOne('App\Models\Escrow', 'transaction_id');
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
