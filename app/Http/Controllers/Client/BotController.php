<?php

namespace App\Http\Controllers\Client;

use DB;
use Auth;
use App\Http\Requests\SaveBotRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Bot\BotRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class BotController extends Controller
{
    protected $botRepository;

    protected $userRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(BotRepositoryInterface $botRepository, UserRepositoryInterface $userRepository)
    {
        $this->botRepository = $botRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($apiKey)
    {
        $response = $this->botRepository->getInforBot($apiKey);

        return response()->json($response);
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
                'id' => Auth::user()->id,
                'api_key' => $request->input('api_key'),
            ]);

            $user->bots()->attach($bots);

            DB::commit();

            return response()->json(true);
        } catch (Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
