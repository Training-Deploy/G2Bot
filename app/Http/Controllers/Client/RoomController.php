<?php

namespace App\Http\Controllers\Client;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Bot\BotRepositoryInterface;
use App\Repositories\Room\RoomRepositoryInterface;

class RoomController extends Controller
{
    /**
     * Room Repository
     *
     * @var RoomRepositoryInterface
     */
    protected $roomRepository;

    /**
     * Bot Repository
     *
     * @var BotRepositoryInterface
     */
    protected $botRepository;

    /**
     * Constructor
     *
     * @param RoomRepositoryInterface $roomRepository
     * @param BotRepositoryInterface $botRepository
     */
    public function __construct(
        RoomRepositoryInterface $roomRepository,
        BotRepositoryInterface $botRepository
    ) {
        $this->roomRepository = $roomRepository;
        $this->botRepository = $botRepository;
    }

    /**
     * Fetch Room
     *
     * @param String $api
     * @return mixed
     */
    public function fetchRooms($api)
    {
        $response = $this->botRepository->getInforBot($api, $this->roomRepository);

        return response()->json($response);
    }

    /**
     * Add room actived
     *
     * @param Request $req
     * @return mixed
     */
    public function store(Request $req)
    {
        $botId = $this->botRepository->getWhere([['api_key', $req->api_key]])->first();
        if ($req->active) {
            $room = [
                'bot_id' => $botId->id,
                'room_name' => $req->room_name,
                'room_id' => $req->room_id,
            ];

            $response = $this->roomRepository->create($room);
        } else {
            $response = $this->roomRepository->getWhere([
                ['bot_id', $botId->id],
                ['room_id', $req->room_id],
            ])->first();

            $response->delete();
        }

        return response()->json(['success' => 'Actived successfully !! ']);
    }
}
