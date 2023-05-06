<?php

namespace NystronSolar\GrowattApiTests\Response;

use NystronSolar\GrowattApi\PHPUnit\GrowattApiTestData;
use NystronSolar\GrowattApi\Response\ApiCheckUserResponse;
use NystronSolar\GrowattApi\Route\ApiCheckUserRoute;
use PHPUnit\Framework\TestCase;

class ApiCheckUserResponseTest extends TestCase
{
    use GrowattApiTestData;

    public function testRequest()
    {
        $route = new ApiCheckUserRoute('');
        /** @var ApiCheckUserResponse|false $response */
        $this->assertNotFalse($response = $this->makeApiClientRequest($route));
        $this->assertSame('', $response->getErrorMessage());
        $this->assertSame(0, $response->getErrorCode());
        $this->assertFalse($response->hasErrors());

        $this->assertFalse($response->userExists());
    }
}
