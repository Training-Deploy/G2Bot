<?php

namespace App\Repositories\Member;

interface MemberRepositoryInterface
{
    /**
     * Update Or create
     *
     * @param array $conditional
     * @param array $attributes
     * @return mixed
     */
    public function updateOrCreate(array $conditional, array $attributes);

    /**
     * Get list members by user id
     *
     * @param integer $userId
     * @return mixed
     */
    public function getListByUser($userId);
}
