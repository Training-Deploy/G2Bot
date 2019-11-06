<?php

namespace App\Repositories\Member;

use Carbon\Carbon;
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
}
