<?php

namespace App\Repositories\Member;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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

    /**
     * Get Members Birthday
     *
     * @param integer $userId
     * @return array member
     */
    public function getMembersBirthday($userId)
    {
        $today = Carbon::now();
        $sartuday = Carbon::now();
        $sartuday->addDays(1);
        $sunday = Carbon::now();
        $sunday->addDays(2);


        $q = $this->model->where('user_id', '=', $userId);

        if ($today->dayOfWeek == 5) {
            $members = $q->get();
            $result = [];
            $result['today'] = [];

            foreach ($members as $member) {
                if (Carbon::parse($member->birthday)->isBirthday()) {
                    $result['today'][] = $member;
                }

                $twoDaysBirthday = Carbon::parse($member->birthday);
                if ($twoDaysBirthday->day == $sartuday->day && $twoDaysBirthday->month == $sartuday->month) {
                    $result['day_off'][] = $member;
                }

                if ($twoDaysBirthday->day == $sunday->day && $twoDaysBirthday->month == $sunday->month) {
                    $result['day_off'][] = $member;
                }
            }
        } else {
            $q->whereDay('birthday', $today->day);
            $result['today'] = $q->whereMonth('birthday', $today->month)->get();
            $result['day_off'] = [];
        }

        return $result;
    }

    /**
     * Delete Member
     *
     * @param Integer $id
     * @return void
     */
    public function deleteMember($id)
    {
        if (Auth::check()) {
            $result = $this->model->where('user_id', Auth::user()->id)->where('id', $id)->delete();
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * Multple Delete
     *
     * @param Array $list
     * @return mixed
     */
    public function multipleDelete($list)
    {
        if (Auth::check()) {
            $result = $this->model->whereIn('id', $list)->delete();
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function updateMember($id, array $attributes)
    {
        $result = $this->model->find($id);
        if ($result && $result->user_id == $attributes['user_id']) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }
}
