<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Review extends Model {
    use SoftDeletes;

    protected $table = "reviews";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating', 'review',
    ];

    /**
     * Relationship: homework
     *  A review belongs to a homework
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function homework(){
        return $this->belongsTo('App\Models\Homework', 'homework_id');
    }

    /**
     * Relationship: reviewer
     *  A review belongs to a reviewer
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function reviewer(){
        return $this->belongsTo('App\User', 'reviewer');
    }

    /**
     * Relationship: reviewee
     *  A review belongs to a reviewee
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function reviewee(){
        return $this->belongsTo('App\User', 'reviewee');
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
