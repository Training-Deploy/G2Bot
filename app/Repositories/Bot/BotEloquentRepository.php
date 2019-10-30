<?php

namespace App\Repositories\Bot;

use App\Repositories\EloquentRepository;
use wataridori\ChatworkSDK\ChatworkSDK;
use wataridori\ChatworkSDK\ChatworkApi;
use wataridori\ChatworkSDK\ChatworkRoom;

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
}
