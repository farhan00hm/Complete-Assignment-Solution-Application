<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HomeworkSolutionFile extends Model {
    use SoftDeletes;

    protected $table = "homework_solution_files";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'original_file_name', 'upload_path',
    ];

    /**
     * Relationship: solution
     *	A homework solution file belongs to a solution
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solution(){
    	return $this->belongsTo('App\Models\HomeworkSolution', 'homework_solution_id');
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
