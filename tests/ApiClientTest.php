<?php

namespace App\Tests;

use GuzzleHttp\Client;
use NystronSolar\GrowattApi\ApiClient;
use NystronSolar\GrowattApi\Route\ApiAllUsersRoute;
use NystronSolar\GrowattApi\Tests\Stubs;
use PHPUnit\Framework\TestCase;

class ApiClientTest extends TestCase
{
    use Stubs;

    public function testGenerateRouteMethod()
    {
        $client = new ApiClient(ApiClient::DEFAULT_API_TOKEN_TEST, ApiClient::DEFAULT_API_URL_TEST, new Client());

        $routeUrl = $client->generateUrl(new ApiAllUsersRoute());

        $this->assertSame('https://test.growatt.com/v1/user/c_user_list', $routeUrl);
    }

    public function testGenerateOptionsMethod()
    {
        $client = new ApiClient(ApiClient::DEFAULT_API_TOKEN_TEST, ApiClient::DEFAULT_API_URL_TEST, new Client());

        $options = $client->generateOptions([]);

        $this->assertSame(['headers' => ['token' => ApiClient::DEFAULT_API_TOKEN_TEST]], $options);
    }
}
