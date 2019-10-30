<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Bot\BotRepositoryInterface;

class BotController extends Controller
{
    protected $botRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(BotRepositoryInterface $botRepository)
    {
        $this->botRepository = $botRepository;
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
}
