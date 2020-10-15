<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FlaggedHomework extends Model {
    use SoftDeletes;

    protected $table = "flagged_homeworks";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'resolution_status', 'reason', 'resolution_date',
    ];

    /**
     * Relationship: homework
     *	A flagged homework belongs to a homework
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function homework(){
    	return $this->belongsTo('App\Models\Homework');
    }


    /**
     * Relationship: flaggedBy
     *	A flagged homework belongs to a user (the user - mainly FL who flags the homework)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flaggedBy(){
    	return $this->belongsTo('App\User', 'flagged_by');
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
