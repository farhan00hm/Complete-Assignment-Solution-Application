<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Expert extends Model {
    use SoftDeletes;

    protected $table = "experts";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'approved', 'qualification', 'description', 'original_file_name', 'resume_path', 'bank_name', 'account_number', 'certificate_path'
    ];


    /**
     * Relationship: user
     *	An expert belongs to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
    	return $this->belongsTo('App\User');
    }

    /**
     * Relationship: subjects
     *  An expert has many subjects
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects(){
        return $this->HasMany('App\Models\Subject');
    }

    /**
     * Relationship: files
     *  An expert has many files
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(){
        return $this->HasMany('App\Models\ExpertFile');
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
