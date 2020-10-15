<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SubCategory extends Model {
    use SoftDeletes;

    protected $table = "sub_categories";

    protected $fillable = [
    	'category_id', 'name', 'description', 'poster_url'
    ];

    /**
     * Relationship: category
     *	A sub category belongs to a category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
    	return $this->belongsTo('App\Models\Category');
    }

    /**
     * Relationship: subject
     *  A sub category has many subjects
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subject(){
        return $this->hasMany('App\Models\Subject');
    }

    /**
     * Relationship: homeworks
     *  A sub category has many homeworks
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function homeworks(){
        return $this->hasMany('App\Models\Homework', 'sub_category_id');
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
