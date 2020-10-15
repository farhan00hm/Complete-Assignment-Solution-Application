<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MessageThread extends Model {
	protected $table = 'message_threads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
    ];

    /**
     * Relationship: messageFrom
     *  A message belongs to a user (sending)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function messageFrom(){
        return $this->belongsTo('App\User', 'from');
    }

    /**
     * Relationship: messageTo
     *  A message belongs to a user (receiving)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function messageTo(){
        return $this->belongsTo('App\User', 'to');
    }

    /**
     * Relationship: room
     *	A thread belongs to a message
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room(){
    	return $this->belongsTo('App\Models\Room', 'room_id');
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
