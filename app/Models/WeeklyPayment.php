<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WeeklyPayment extends Model {
    use SoftDeletes;

    protected $table = "weekly_payments";

    /**
     * Relationship: user
     *  A weekly payment belongs to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user(){
        return $this->BelongsTo('App\User');
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
