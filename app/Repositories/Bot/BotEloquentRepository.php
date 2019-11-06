<?php

namespace App\Repositories\Bot;

use App\Repositories\EloquentRepository;
use wataridori\ChatworkSDK\ChatworkSDK;
use wataridori\ChatworkSDK\ChatworkApi;
use wataridori\ChatworkSDK\ChatworkRoom;
use wataridori\ChatworkSDK\ChatworkUser;

class BotEloquentRepository extends EloquentRepository implements BotRepositoryInterface
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Bot::class;
    }

    /**
     * Get Information Bot.
     *
     * @params string $apiKey
     *
     * @return string
     */
    public function getInforBot($apiKey)
    {
        ChatworkSDK::setApiKey($apiKey);
        $api = new ChatworkApi();
        $infor = $api->me();
        $rooms = $api->getRooms();

        foreach ($rooms as $key => $room) {
            if ($room['type'] !== 'group') {
                unset($rooms[$key]);
            }
        }

        return [
            'infor' => $infor,
            'rooms' => $rooms,
        ];
    }

    /**
     * Send Message Birthday
     *
     * @param String $apiKey
     * @param String $message
     * @param integer $accountTo
     * @return void
     */
    public function sendMessageBirthDay($apiKey, $message, $accountTo)
    {
        ChatworkSDK::setApiKey($apiKey);
        $data = new ChatworkApi;
        // Get list friends
        $listContacts = $data->getContacts();
        $roomPrivate = null;

        // Get room id of account to
        foreach ($listContacts as $contacts) {
            if ($contacts['account_id'] == $accountTo) {
                $roomPrivate = $contacts['room_id'];
            }
        }

        $user = new ChatworkUser($accountTo);
        $room = new ChatworkRoom($roomPrivate);
        $room->sendMessageToList([$user], $message);
    }
}
