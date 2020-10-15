<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Commission extends Model {
    use SoftDeletes;

    protected $table = "commissions";

    /**
     * Relationship: homework
     *  A commission belongs to a homework
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function homework(){
        return $this->belongsTo('App\Models\Homework', 'homework_id');
    }

    /**
     * Relationship: escrow
     *  A commission belongs to an escrow entry
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function escrow(){
        return $this->belongsTo('App\Models\Escrow', 'escrow_id');
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
