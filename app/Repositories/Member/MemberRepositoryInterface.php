<?php

namespace App\Repositories\Member;

interface MemberRepositoryInterface
{
    /**
     * Get list members by user id
     *
     * @param integer $userId
     * @return mixed
     */
    public function getListByUser($userId);
}
