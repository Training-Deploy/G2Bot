<?php

namespace App\Repositories\Member;

use App\Repositories\EloquentRepository;

class MemberEloquentRepository extends EloquentRepository implements MemberRepositoryInterface
{
    /**
     * get model.
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Member::class;
    }


    /**
     * Get List By User
     *
     * @param integer $userId
     * @return mixed
     */
    public function getListByUser($userId)
    {
        return $this->model->where('user_id', '=', $userId);
    }
}
