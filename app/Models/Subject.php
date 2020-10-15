<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subject extends Model {
    use SoftDeletes;

    protected $table = "subjects";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'expert_id', 'sub_category_id'
    ];

    /**
     * Relationship: expert
     *	A subject belongs to an expert
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expert(){
    	return $this->belongsTo('App\Models\Expert');
    }

    /**
     * Relationship: subCategory
     *  A subject belongs to a sub category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory(){
        return $this->belongsTo('App\Models\SubCategory');
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
