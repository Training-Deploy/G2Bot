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
    public function getInforBot($apiKey, $roomRepository)
    {
        ChatworkSDK::setApiKey($apiKey);
        $api = new ChatworkApi();
        $infor = $api->me();
        $rooms = $api->getRooms();
        $botId = $this->model->where('api_key', $apiKey)->first();

        foreach ($rooms as $key => $room) {
            if ($room['type'] !== 'group') {
                unset($rooms[$key]);
            } else {
                if ($botId) {
                    $rooms[$key]['active'] = $roomRepository->isActive($botId->id, $room['room_id']);
                }
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
        $roomPrivate = $this->getPrivateRoom($listContacts, $accountTo);
        $user = new ChatworkUser($accountTo);
        $roomPrivate->sendMessageToList([$user], $message);
    }

    /**
     * Send Message birthday to rooms
     *
     * @param string $apiKey
     * @param string $message
     * @param integer $accountTo
     * @param mixed $roomIds
     * @return void
     */
    public function sendMessageBirthDayToRooms($apiKey, $message, $toIds, $roomIds)
    {
        ChatworkSDK::setApiKey($apiKey);
        $data = new ChatworkApi;
        $users = $this->makeInstanceUsers($toIds);
        // Each room ids and send msg
        foreach ($roomIds as $roomId) {
            $room = new ChatworkRoom($roomId->room_id);
            $room->sendMessageToList($users, $message);
        }
    }

    /**
     * Update Status To Group of bot
     *
     * @param boolean $toGroup
     * @param string $apiKey
     */
    public function updateStatus($toGroup, $apiKey)
    {
        $bot = $this->model->where('api_key', $apiKey)->first();
        $bot->to_group = $toGroup;
        $bot->save();
    }

    /**
     * Make Instance Users
     *
     * @param array $toIds
     * @return ChatworkUser[]
     */
    public function makeInstanceUsers($toIds)
    {
        $dataList = [];
        foreach ($toIds as $id) {
            $dataList[] = new ChatworkUser($id);
        }

        return $dataList;
    }

    /**
     * Get Private room of id user chatwork
     *
     * @param array $listContacts
     * @param integer $accountTo
     * @return ChatworkRoom
     */
    public function getPrivateRoom($listContacts, $accountTo)
    {
        // Get room id of account to
        foreach ($listContacts as $contacts) {
            if ($contacts['account_id'] == $accountTo) {
                $roomPrivate = $contacts['room_id'];
            }
        }

        return new ChatworkRoom($roomPrivate);
    }
}
