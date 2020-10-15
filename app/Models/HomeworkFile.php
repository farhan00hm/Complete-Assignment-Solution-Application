<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HomeworkFile extends Model {
    use SoftDeletes;

    protected $table = "homework_files";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'homework_id', 'upload_path',
    ];

    /**
     * Relationship: homework
     *	A homework file belongs to a homework
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function homework(){
    	return $this->belongsTo('App\Models\Homework');
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
