<?php

namespace Tests\Feature\Controller;

use App\Http\Controllers\UserController;
use App\Services\ProviderService;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    private UserController $controller;
    private ProviderService $providerService;

    public function setUp(): void
    {
        parent::setUp();

        $this->providerService = new ProviderService();
        $this->controller = new UserController($this->providerService);
    }

    public function testCanGetUsersFromProviderX()
    {
        $request = new Request();
        $request->merge(['provider' => ProviderService::PROVIDER_X]);

        $response = $this->controller->getUsers($request);
        $data = json_decode($response->getContent(), true);

        $this->assertCount(4, $data['data']);
        $this->assertEquals('DataProviderX', $data['data'][0]['provider']);
    }

    public function testCanGetUsersFromProviderY()
    {
        $request = new Request();
        $request->merge(['provider' => ProviderService::PROVIDER_Y]);

        $response = $this->controller->getUsers($request);
        $data = json_decode($response->getContent(), true);

        $this->assertCount(5, $data['data']);
        $this->assertEquals('DataProviderY', $data['data'][0]['provider']);
    }

    public function testCanFilterUsersByStatus()
    {
        $request = new Request();
        $request->merge(['status' => 'authorised']);

        $response = $this->controller->getUsers($request);
        $data = json_decode($response->getContent(), true);

        $this->assertCount(9, $data['data']);
        $this->assertEquals('authorised', $data['data'][0]['status']);
    }

    public function testCanFilterUsersByBalance()
    {
        $request = new Request();
        $request->merge(['balanceMin' => 300]);
        $request->merge(['balanceMax' => 400]);

        $response = $this->controller->getUsers($request);
        $data = json_decode($response->getContent(), true);

        $this->assertCount(7, $data['data']);
    }

    public function testCanFilterUsersByCurrency()
    {
        $request = new Request();
        $request->merge(['currency' => 'USD']);

        $response = $this->controller->getUsers($request);
        $data = json_decode($response->getContent(), true);

        $this->assertCount(4, $data['data']);
        $this->assertEquals('USD', $data['data'][0]['currency']);
    }
}


