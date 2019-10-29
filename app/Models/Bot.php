<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    protected $table = 'bots';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'api_key',
    ];

    /**
     *  The users that belong to the bot.
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    /**
     *  Get the Messages for the Bot
     */
    public function messages()
    {
        return $this->hasManyThrough(
            'App\Models\Message',
            'App\Models\BotUser',
            'bot_id',
            'user_bot_id',
            'id',
            'id'
        );
    }
}
