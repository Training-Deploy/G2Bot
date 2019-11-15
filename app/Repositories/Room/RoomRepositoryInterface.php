<?php

namespace App\Repositories\Room;

interface RoomRepositoryInterface
{
    /**
     * Check is active room
     *
     * @param integer $botId
     * @param integer $roomId
     * @return boolean
     */
    public function isActive($botId, $roomId);

     /**
     * Get List Room Active
     *
     * @param integer $botId
     * @return mixed
     */
    public function getListActive($botId);
}
