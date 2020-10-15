<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'user_type', 'password', 'email_verified_at', 'onboarded', 'wallet', 'school', 'password_changed', 'gender', 'phone', 'dob'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship: comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */

    /**
     * Check if a user is an admin or subadmin (privileged user)
     *
     * @return bool
    */
    public function isPrivileged(){
        if($this->user_type == "Admin" || $this->user_type == "Subadmin"){
            return true;
        }

        return false;
    }

    /**
     * Relationship: expert
     *  A user has one expert
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function expert(){
        return $this->HasOne('App\Models\Expert');
    }

    /**
     * Relationship: socialiteAccount
     *  A user has one socialite account
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function socialiteAccount(){
        return $this->HasOne('App\Models\SocialiteAccount');
    }

    /**
     * Relationship: posted
     *  A user can post many homeworks
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function posted(){
        return $this->hasMany('App\Models\Homework', 'posted_by');
    }

    /**
     * Relationship: awarded
     *  A user can be awarded many homeworks
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function awarded(){
        return $this->hasMany('App\Models\Homework', 'awarded_to');
    }

    /**
     * Relationship: bids
     *  A user has many bids
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function bids(){
        return $this->hasMany('App\Models\Bid', 'user_id');
    }

    /**
     * Relationship: transactionFrom
     *  A user can have many transactions from their wallet
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function transactionFrom(){
        return $this->hasMany('App\Models\Transaction', 'from_user');
    }

    /**
     * Relationship: transactionTo
     *  A user can have many transactions credeting their wallet
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function transactionTo(){
        return $this->hasMany('App\Models\Transaction', 'to_user');
    }

    /**
     * Relationship: transactionInitiator
     *  A user initiate many transactions (This is mostly admin user when processing transactions)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function transactionInitiator(){
        return $this->hasMany('App\Models\Transaction', 'initiator');
    }


    /**
     * Relationship: flaggedHomeworks
     *  A user can flag many homeworks
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function flaggedHomeworks(){
        return $this->hasMany('App\Models\FlaggedHomework', 'flagged_by');
    }

    /**
     * Relationship: fromMessages
     *  A user has many messages (can send)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function fromMessages(){
        return $this->hasMany('App\Models\Message', 'from_user_id');
    }

    /**
     * Relationship: toMessages
     *  A user has many messages (can receive)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function toMessages(){
        return $this->hasMany('App\Models\Message', 'to_user_id');
    }


    /**
     * Relationship: discountCodesCreated
     *  A user can create many discount codes (user - Admin/Subadmin)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function discountCodesCreated(){
        return $this->hasMany('App\Models\DiscountCode', 'created_by');
    }

    /**
     * Relationship: discountCodesGiven
     *  A user can award many discount codes (user - Admin/Subadmin) to a Student/Professional/FL
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function discountCodesGiven(){
        return $this->hasMany('App\Models\DiscountCode', 'discounted_by');
    }

    /**
     * Relationship: discountCodesReceived
     *  A user can receive many discount codes(Student/Professional/FL)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function discountCodesReceived(){
        return $this->hasMany('App\Models\DiscountCode', 'discounted_to');
    }

    /**
     * Relationship: redeemed
     *  A user can redeem many discount codes
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function redeemed(){
        return $this->hasMany('App\Models\CodeRedeemer', 'user_id');
    }


    /**
     * Relationship: reviewer
     *  A user can review many users
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function reviewer(){
        return $this->hasMany('App\Models\Review', 'reviewer');
    }

    /**
     * Relationship: reviewee
     *  A user can be reviewed many other users
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function reviewee(){
        return $this->hasMany('App\Models\Review', 'reviewee');
    }

    /**
     * Relationship: weeklyPayments
     *  A user (admin/subadmin) has many weekly payments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function weeklyPayments(){
        return $this->hasMany('App\Models\WeeklyPayment');
    }





    /**
     * Check if a user has role
     *
     * @return bool
    */
    public function isAdmin(){
        if($this->roles()->first()->name === "Admin"){
            return true;
        }

        return false;
    }

    /**
     * Check if a subadmin has customer service role
     *
     * @return bool
    */
    public function isCS(){
        if($this->roles()->first()->name == "SubCS"){
            return true;
        }

        return false;
    }

    /**
     * Check if a subadmin has dispute management role
     *
     * @return bool
    */
    public function isD(){
        if($this->roles()->first()->name === "SubD"){
            return true;
        }

        return false;
    }

    /**
     * Check if a subadmin has Payroll download role
     *
     * @return bool
    */
    public function isP(){
        if($this->roles()->first()->name === "SubP"){
            return true;
        }

        return false;
    }

    /**
     * Check if a subadmin has authentication role
     *
     * @return bool
    */
    public function isAuth(){
        if($this->roles()->first()->name === "SubAuth"){
            return true;
        }

        return false;
    }

    /**
     * Check if a subadmin has system admin role
     *
     * @return bool
    */
    public function isSys(){
        if($this->roles()->first()->name === "SubSys"){
            return true;
        }

        return false;
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
