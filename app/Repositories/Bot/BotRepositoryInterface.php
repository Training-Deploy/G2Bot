<?php

namespace App\Repositories\Bot;

interface BotRepositoryInterface
{
     /**
     * Get  Information Bot.
     *
     * @params string $apiKey
     */
    public function getInforBot($apiKey);
}
