<?php

namespace App\Http\Controllers\Client;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;

class HomeController extends Controller
{
    protected $userRepository;

     /**
     * Constructor
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Index
     *
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json($this->userRepository->findWith(Auth::user()->id, ['bots']));
        }

        return view('clients.master');
    }
}
