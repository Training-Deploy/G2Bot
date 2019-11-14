<?php

namespace App\Http\Controllers\Client;

use DB;
use Auth;
use App\Http\Requests\SaveBotRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Bot\BotRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Member\MemberRepositoryInterface;
use App\Repositories\Room\RoomRepositoryInterface;
use App\Repositories\BotUser\BotUserRepositoryInterface;
use wataridori\ChatworkSDK\Exception\RequestFailException;
use Illuminate\Http\Request;

class BotController extends Controller
{
    protected $botRepository;

    protected $userRepository;

    protected $memberRepository;

    protected $roomRepository;

    protected $botUserRepository;
    /**
     * Create a new controller instance.
     */
    public function __construct(
        BotRepositoryInterface $botRepository,
        UserRepositoryInterface $userRepository,
        MemberRepositoryInterface $memberRepository,
        RoomRepositoryInterface $roomRepository,
        BotUserRepositoryInterface $botUserRepository
    ) {
        $this->botRepository = $botRepository;
        $this->userRepository = $userRepository;
        $this->memberRepository = $memberRepository;
        $this->roomRepository = $roomRepository;
        $this->botUserRepository = $botUserRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($apiKey)
    {
        try {
            $response = $this->botRepository->getInforBot($apiKey, $this->roomRepository);

            return response()->json($response);
        } catch (RequestFailException $ex) {
            return response()->json(['message' => 'API Invalid'], 422);
        }
    }


    /**
     * Save ApiKey and Acound Id
     *
     * @param  mixed $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SaveBotRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->userRepository->update(Auth::user()->id, [
                'account_id' => $request->input('account_id'),
            ]);
            $bots = $this->botRepository->updateOrCreate([
                'api_key' => $request->input('api_key'),
            ]);

            if (!$user->bots->contains($bots->id)) {
                $this->botUserRepository->updateOrCreate([
                    'user_id' => Auth::user()->id,
                ], [
                    'bot_id' => $bots->id,
                ]);
            }

            DB::commit();

            return response()->json(['success' => 'Saved !'], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * Update Bot To Group Status
     *
     * @param Request $request
     * @param string $apiKey
     * @return mixed
     */
    public function update(Request $request, $apiKey)
    {
        if (Auth::check()) {
            try {
                $this->botRepository->updateStatus($request->to_group, $apiKey);
                return response()->json(['success' => 'Updated !!'], 200);
            } catch (\ErrorException $ex) {
                return response()->json(['message' => 'Update status error , please add bot'], 422);
            }
        }

        return response()->json(false);
    }
}
