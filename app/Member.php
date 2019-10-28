<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = "members";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'phone',
        'birthday',
        'github_account',
        'viblo_link',
        'gmail',
        'chatwork_account',
        'company_email',
        'ssh_key',
        'user_id'
    ];
    
    /**
     * Get the user that owns the member
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
