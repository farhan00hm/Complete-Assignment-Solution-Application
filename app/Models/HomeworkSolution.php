<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HomeworkSolution extends Model {
    use SoftDeletes;

    protected $table = "homework_solutions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'notes',
    ];

    /**
     * Relationship: homework
     *	A homework solution belongs to a homework
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function homework(){
    	return $this->belongsTo('App\Models\Homework', 'homework_id');
    }

    /**
     * Relationship: files
     *	A homework solution has many solution files
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(){
    	return $this->HasMany('App\Models\HomeworkSolutionFile', 'homework_solution_id');
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
