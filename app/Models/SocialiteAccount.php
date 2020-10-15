<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SocialiteAccount extends Model {
	use SoftDeletes;

    protected $table = "socialite_accounts";

    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    /**
     * Relationship: user
     *	An socialite account belongs to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
    	return $this->belongsTo('App\User');
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
