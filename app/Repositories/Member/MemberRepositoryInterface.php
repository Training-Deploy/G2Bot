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
    /**
     * Get Members Birthday
     *
     * @param integer $userId
     * @return array member
     */
    public function getMembersBirthday($userId);

    /**
     * Multple Delete
     *
     * @param Array $list
     * @return mixed
     */
    public function multipleDelete($list);

    /**
     * Delete Member
     *
     * @param Integer $id
     * @return void
     */
    public function deleteMember($id);

     /**
     * Update
     * @param Integer $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function updateMember($id, array $attributes);
}
