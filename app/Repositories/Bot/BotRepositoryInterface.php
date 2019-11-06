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
    /**
     * Send Message Birthday
     *
     * @param String $apiKey
     * @param Array $dataMems
     * @param integer $accountTo
     * @return void
     */
    public function sendMessageBirthDay($apiKey, $dataMems, $accountTo);
}
