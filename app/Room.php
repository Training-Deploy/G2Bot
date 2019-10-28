<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = "rooms";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'room_name', 'room_id', 'bot_id'
    ];

    /**
     *  Get the bot that owns the room
     */
    public function bot()
    {
        return $this->belongsTo('App\Bot');
    }

    /**
     *  Get the messages for the room
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }
}
