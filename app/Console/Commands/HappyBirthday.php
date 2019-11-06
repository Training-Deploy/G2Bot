<?php

namespace App\Console\Commands;

use Auth;
use Illuminate\Console\Command;
use App\Repositories\Bot\BotRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Member\MemberRepositoryInterface;

class HappyBirthday extends Command
{
    protected $botRepository;

    protected $userRepository;

    protected $memberRepository;
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
        MemberRepositoryInterface $memberRepository
    ) {
        parent::__construct();
        $this->botRepository = $botRepository;
        $this->userRepository = $userRepository;
        $this->memberRepository = $memberRepository;
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
                if (isset($membersBirthday['today']) && count($membersBirthday['today']) > 0) {
                    foreach ($membersBirthday['today'] as $member) {
                        $message .= "[info] Hôm nay là sinh nhật {$member->full_name} , ngày {$member->birthday} ,";
                        $message .= "anh/chị {$user->name} đã chuẩn bị quà chưa ạ :D [/info]";
                    }
                }
                
                if (isset($membersBirthday['day_off']) && count($membersBirthday['day_off']) > 0) {
                    $message .= 'Do mai với ngày kia là ngày nghỉ nên BOT thông báo các bạn ';
                    $message .= 'có sinh nhật trong ngày mai với ngày kia luôn ạ : ';

                    foreach ($membersBirthday['day_off'] as $member) {
                        $message .= "[info] Sinh nhật của {$member->full_name}, ngày {$member->birthday} (F) [/info]";
                    }
                }
                
                if ($message != '') {
                    foreach ($user->bots as $bot) {
                        $this->botRepository->sendMessageBirthDay($bot->api_key, $message, $user->account_id);
                    }
                }
            }
        }

        $this->info('The happy birthday messages were sent successfully!');
    }
}
