<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use willvincent\Rateable\Rateable;

class Homework extends Model {
    use SoftDeletes;
    use Rateable;

    protected $table = "homeworks";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'awarded_to', 'sub_category_id', 'title', 'status', 'description', 'deadline', 'budget', 'winning_bid_amount',  'winning_bid_id', 'hired_on',
    ];

    /**
     * Relationship: postedBy
     *	A homework belongs to a user (posted by - student or non student)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function postedBy(){
    	return $this->belongsTo('App\User', 'posted_by');
    }

    /**
     * Relationship: awardedTo
     *	A homework belongs to a user (awarded to - solution expert)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function awardedTo(){
    	return $this->belongsTo('App\User', 'awarded_to');
    }

    /**
     * Relationship: subcategory
     *	A homework belongs to subcategory
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcategory(){
    	return $this->belongsTo('App\Models\SubCategory', 'sub_category_id');
    }

    /**
     * Relationship: files
     *  A homework has zero or many files
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function files(){
        return $this->hasMany('App\Models\HomeworkFile');
    }

    /**
     * Relationship: bids
     *  A homework has zero or many bids
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function bids(){
        return $this->hasMany('App\Models\Bid', 'homework_id');
    }

    /**
     * Relationship: winningBid
     *  A homework has zero or one winning bid
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
    */
    public function winningBid(){
        return $this->belongsTo('App\Models\Bid', 'winning_bid_id');
//        return $this->belongsTo('App\Models\Bid', 'homework_id');
    }

    /**
     * Relationship: transaction
     *  A homework has zero or one transaction
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function transaction(){
        return $this->HasOne('App\Models\Transaction', 'homework_id');
    }

    /**
     * Relationship: escrow
     *  A homework has zero or one escrow
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function escrow(){
        return $this->HasOne('App\Models\Escrow', 'homework_id');
    }

    /**
     * Relationship: flags
     *  A homework has zero or many flags
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function flags(){
        return $this->hasMany('App\Models\FlaggedHomework');
    }

    /**
     * Relationship: solution
     *  A homework has zero or one solution
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function solution(){
        return $this->HasOne('App\Models\HomeworkSolution', 'homework_id');
    }

    /**
     * Relationship: commission
     *  A homework has zero or one commission
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function commission(){
        return $this->HasOne('App\Models\Commission', 'homework_id');
    }

    /**
     * Relationship: reviews
     *  A homework has zero or many reviews
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function reviews(){
        return $this->hasMany('App\Models\Review', 'homework_id');
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
