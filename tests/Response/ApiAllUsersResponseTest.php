<?php

namespace NystronSolar\GrowattApiTests\Response;

use NystronSolar\GrowattApi\Entity\User;
use NystronSolar\GrowattApi\PHPUnit\GrowattApiTestData;
use NystronSolar\GrowattApi\Response\ApiAllUsersResponse;
use NystronSolar\GrowattApi\Route\ApiAllUsersRoute;
use PHPUnit\Framework\TestCase;

class ApiAllUsersResponseTest extends TestCase
{
    use GrowattApiTestData;

    public function testRequest()
    {
        $route = new ApiAllUsersRoute();
        /** @var ApiAllUsersResponse|false $response */
        $this->assertNotFalse($response = $this->makeApiClientRequest($route));
        $this->assertSame('', $response->getErrorMessage());
        $this->assertSame(0, $response->getErrorCode());
        $this->assertFalse($response->hasErrors());

        $users = $response->getUsers();

        $this->assertCount(2, $users);
        $this->assertEquals(new User(1, 'Growatt User One', 'user.one@growatt.com', '', '2023-01-01 01:01:01'), $users[0]);
    }
}
