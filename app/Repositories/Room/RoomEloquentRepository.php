<?php

namespace App\Repositories\Room;

use App\Repositories\EloquentRepository;

class RoomEloquentRepository extends EloquentRepository implements RoomRepositoryInterface
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Room::class;
    }

    /**
     * Check is active room
     *
     * @param integer $botId
     * @param integer $roomId
     * @return boolean
     */
    public function isActive($botId, $roomId)
    {
        $result = $this->model->where([
            ['bot_id', $botId],
            ['room_id', $roomId],
        ])->get();

        return $result->count() > 0 ? true : false;
    }

    /**
     * Get List Room Active
     *
     * @param integer $botId
     * @return mixed
     */
    public function getListActive($botId)
    {
        return $this->model->where('bot_id', $botId);
    }
}
