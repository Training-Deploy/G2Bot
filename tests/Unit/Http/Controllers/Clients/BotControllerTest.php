<?php

namespace Tests\Unit\Http\Controllers\Clients;

use App\Http\Controllers\Client\BotController;
use Mockery as m;
use Tests\TestCase;
use App\Repositories\Bot\BotRepositoryInterface;
use App\Repositories\BotUser\BotUserRepositoryInterface;
use App\Repositories\Member\MemberRepositoryInterface;
use App\Repositories\Room\RoomRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BotControllerTest extends TestCase
{

    /**
     * setUp
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
        $this->afterApplicationCreated(function() {
            $this->botRepoMock = m::Mock($this->app->make(BotRepositoryInterface::class));
            $this->userRepoMock = m::Mock($this->app->make(UserRepositoryInterface::class));
            $this->memberRepoMock = m::Mock($this->app->make(MemberRepositoryInterface::class));
            $this->roomRepoMock = m::Mock($this->app->make(RoomRepositoryInterface::class));
            $this->botUserRepoMock = m::Mock($this->app->make(BotUserRepositoryInterface::class));
            $this->botController = new BotController(
                $this->botRepoMock,
                $this->userRepoMock,
                $this->memberRepoMock,
                $this->roomRepoMock,
                $this->botUserRepoMock
            );
        });
    }

    /**
     * test_show
     *
     * @return void
     */
    public function test_show_bot_succsee()
    {
        $apiKey = '9afdea56ed604a9bc6a28a64c8cd365b';
        $response = $this->botController->show($apiKey);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * test_show_bot_fail
     *
     * @return void
     */
    public function test_show_bot_fail()
    {
        $apiKey = 'test_api_key';
        $expectedData = [
            'message' => 'Api Invalid',
        ];
        $response = $this->botController->show($apiKey);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    // public function test_store_bot_success()
    // {
    //     //
    // }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown() : void
    {
        parent::tearDown();
        \Mockery::close();
    }

}
