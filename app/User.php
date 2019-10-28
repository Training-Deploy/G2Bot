<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'account_id'
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
     *  Get the members for the user 
     */
    public function members()
    {
        return $this->hasMany('App\Member');
    }

    /**
     *  Get the excels for the user 
     */
    public function excels()
    {
        return $this->hasMany('App\Excel');
    }

    /**
     *  The bots that belong to the user.
     */
    public function bots()
    {
        return $this->belongsToMany('App\Bot');
    }

    /**
     *  Get the messages for the user
     */
    public function messages()
    {
        return $this->hasManyThrough(
            'App\Message',
            'App\BotUser',
            'user_id',
            'bot_user_id',
            'id',
            'id'
        );
    }
}
