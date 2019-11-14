<?php

namespace App\Repositories\Bot;

use App\Repositories\Room\RoomRepositoryInterface;

interface BotRepositoryInterface
{
     /**
     * Get  Information Bot.
     *
     * @params string $apiKey
     */
    public function getInforBot($apiKey, RoomRepositoryInterface $roomRepository);
    /**
     * Send Message Birthday
     *
     * @param String $apiKey
     * @param Array $dataMems
     * @param integer $accountTo
     * @return void
     */
    public function sendMessageBirthDay($apiKey, $dataMems, $accountTo);

    /**
     * Send Message birthday to rooms
     *
     * @param string $apiKey
     * @param string $message
     * @param integer $accountTo
     * @param mixed $roomIds
     * @return void
     */
    public function sendMessageBirthDayToRooms($apiKey, $message, $accountTo, $roomIds);

    /**
     * Update Status To Group of bot
     *
     * @param boolean $toGroup
     * @param string $apiKey
     */
    public function updateStatus($toGroup, $apiKey);

    /**
     * Make Instance Users
     *
     * @param array $toIds
     * @return ChatworkUser[]
     */
    public function makeInstanceUsers($toIds);

    /**
     * Get Private room of id user chatwork
     *
     * @param array $listContacts
     * @param integer $accountTo
     * @return ChatworkRoom
     */
    public function getPrivateRoom($listContacts, $accountTo);
}
