<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Excel extends Model
{
    protected $table = 'excels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'link',
        'user_id',
    ];

    /**
     * Get the user that owns the user
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
