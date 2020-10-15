<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ExpertFile extends Model {
    use SoftDeletes;

    protected $table = "expert_files";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'original_file_name', 'upload_path',
    ];


    /**
     * Relationship: expert
     *	An file belongs to an expert
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expert(){
    	return $this->belongsTo('App\Models\Expert');
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
