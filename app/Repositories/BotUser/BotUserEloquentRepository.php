<?php

namespace App\Repositories\BotUser;

use App\Repositories\EloquentRepository;

class BotUserEloquentRepository extends EloquentRepository implements BotUserRepositoryInterface
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\BotUser::class;
    }
}
