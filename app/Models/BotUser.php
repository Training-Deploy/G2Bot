<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BotUser extends Pivot
{
    protected $table = 'bot_user';
}
