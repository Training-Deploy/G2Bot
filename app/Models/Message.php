<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'room_id',
        'user_id',
        'bot_id',
    ];

    /**
     *  Get bot of message
     */
    public function bot()
    {
        return $this->hasOneThrough(
            'App\Models\Bot',
            'App\Models\BotUser',
            'id',
            'id',
            'bot_user_id',
            'bot_id'
        );
    }
    
    /**
     *  Get the user that owns the message
     */
    public function user()
    {
        return $this->hasOneThrough(
            'App\Models\User',
            'App\Models\BotUser',
            'id',
            'id',
            'bot_user_id',
            'user_id'
        );
    }

    /**
     *  Get the room that owns the message
     */
    public function room()
    {
        return $this->belongsTo('App\Models\Room');
    }
}
