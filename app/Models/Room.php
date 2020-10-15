<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Room extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_message', 'from', 'to'
    ];

    /**
     * Relationship: messageFrom
     *	A message belongs to a user (sending)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function messageFrom(){
    	return $this->belongsTo('App\User', 'from');
    }

    /**
     * Relationship: messageTo
     *	A message belongs to a user (receiving)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function messageTo(){
    	return $this->belongsTo('App\User', 'to');
    }

    /**
     * Relationship: threads
     *	A message has many threads
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads(){
    	return $this->HasMany('App\Models\MessageThread', 'room_id');
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
