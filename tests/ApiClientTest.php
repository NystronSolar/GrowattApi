<?php

namespace App\Tests;

use NystronSolar\GrowattApi\ApiClient;
use NystronSolar\GrowattApi\Route\ApiAllUsersRoute;
use PHPUnit\Framework\TestCase;

class ApiClientTest extends TestCase
{
    public function testGenerateRouteMethod()
    {
        $client = new ApiClient(ApiClient::DEFAULT_API_TOKEN_TEST, ApiClient::DEFAULT_API_URL_TEST);

        $routeUrl = $client->generateUrl(new ApiAllUsersRoute());

        $this->assertSame('https://test.growatt.com/v1/user/c_user_list', $routeUrl);
    }

    public function testGenerateOptionsMethodEmptyParams()
    {
        $client = new ApiClient(ApiClient::DEFAULT_API_TOKEN_TEST, ApiClient::DEFAULT_API_URL_TEST);

        $options = $client->generateOptions([]);

        $this->assertSame(['headers' => ['token' => ApiClient::DEFAULT_API_TOKEN_TEST], 'query' => []], $options);
    }

    public function testGenerateOptionsMethodWithParams()
    {
        $client = new ApiClient(ApiClient::DEFAULT_API_TOKEN_TEST, ApiClient::DEFAULT_API_URL_TEST);

        $params = ['user_name' => 'name'];

        $options = $client->generateOptions($params);

        $this->assertSame(['headers' => ['token' => ApiClient::DEFAULT_API_TOKEN_TEST], 'query' => $params], $options);
    }
}
