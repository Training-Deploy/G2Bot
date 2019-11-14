<?php

namespace App\Console\Commands;

use Auth;
use Illuminate\Console\Command;
use App\Repositories\Bot\BotRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Member\MemberRepositoryInterface;
use App\Repositories\Room\RoomRepositoryInterface;

class HappyBirthday extends Command
{
    /**
     * Bot Repository
     *
     * @var \App\Repositories\BotUser\BotUserRepositoryInterface
     */
    protected $botRepository;

    /**
     * User Repository
     *
     * @var \App\Repositories\User\UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * Member Repository
     *
     * @var \App\Repositories\Member\MemberRepositoryInterface
     */
    protected $memberRepository;

    /**
     * Room Repository
     *
     * @var \App\Repositories\Room\RoomRepositoryInterface
     */
    protected $roomRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatwork:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all notification to id chatwork groupleader';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        BotRepositoryInterface $botRepository,
        UserRepositoryInterface $userRepository,
        MemberRepositoryInterface $memberRepository,
        RoomRepositoryInterface $roomRepository
    ) {
        parent::__construct();
        $this->botRepository = $botRepository;
        $this->userRepository = $userRepository;
        $this->memberRepository = $memberRepository;
        $this->roomRepository = $roomRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $listUsers = $this->userRepository->getWith(['bots']);
        foreach ($listUsers as $user) {
            $membersBirthday = $this->memberRepository->getMembersBirthday($user->id);
            if (count($membersBirthday) > 0 && count($user->bots) > 0 && $user->account_id) {
                $message = '';
                $toIds = [];
                if (isset($membersBirthday['today']) && count($membersBirthday['today']) > 0) {
                    $this->makeMessageToday($membersBirthday, $message, $toIds);
                }
                
                if (isset($membersBirthday['day_off']) && count($membersBirthday['day_off']) > 0) {
                    $this->makeMessageDayOff($membersBirthday, $message, $toIds);
                }
                
                $this->send($message, $user, $toIds);
            }
        }
    }

    /**
     * Make Message Today
     *
     * @param array $membersBirthday
     * @param string $message
     * @param array $toIds
     */
    public function makeMessageToday($membersBirthday, &$message, &$toIds)
    {
        foreach ($membersBirthday['today'] as $member) {
            $message .= "[info] Hôm nay là sinh nhật {$member->full_name} , ngày {$member->birthday} ,";
            $message .= 'anh/chị Leader đã chuẩn bị quà chưa ạ :D [/info]';
            $toIds[] = $member->chatwork_account;
        }
    }

    /**
     * Make Message Members Day Off
     *
     * @param array $membersBirthday
     * @param string $message
     * @param array $toIds
     */
    public function makeMessageDayOff($membersBirthday, &$message, &$toIds)
    {
        $message .= 'Do mai với ngày kia là ngày nghỉ nên BOT thông báo các bạn ';
        $message .= 'có sinh nhật trong ngày mai với ngày kia lun : ';

        foreach ($membersBirthday['day_off'] as $member) {
            $message .= "[info] Chúc mừng Sinh nhật của {$member->full_name}, ngày {$member->birthday} (F) [/info]";
            $toIds[] = $member->chatwork_account;
        }
    }

    /**
     * Send Message to chatwork
     *
     * @param string $message
     * @param array $user
     * @param array $toIds
     */
    public function send(&$message, $user, $toIds)
    {
        if ($message != '') {
            foreach ($user->bots as $bot) {
                if ($bot->to_group) {
                    $listRoom = $this->roomRepository->getListActive($bot->id)->get();
                    $this->botRepository->sendMessageBirthDayToRooms(
                        $bot->api_key,
                        $message,
                        $toIds,
                        $listRoom
                    );
                } else {
                    $this->botRepository->sendMessageBirthDay($bot->api_key, $message, $user->account_id);
                }
            }
        }

        $this->info('The happy birthday messages were sent successfully!');
    }
}
