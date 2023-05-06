<?php

namespace NystronSolar\GrowattApi\PHPUnit;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use NystronSolar\GrowattApi\ApiClient;
use NystronSolar\GrowattApi\Response\ApiResponse;
use NystronSolar\GrowattApi\Route\ApiRoute;

/**
 * This class should ONLY be used in TESTS.
 *
 * The parent class HAVE to be extending the TestCase PHPUnit Class
 */
trait GrowattApiTestData
{
    public function readThisFolder(string $path): string|false
    {
        $file = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.$path);

        return $file;
    }

    public function readJson(ApiRoute $apiRoute): string|false
    {
        $apiResponseClassExploded = explode('\\', $apiRoute->getApiResponse());
        $filename = end($apiResponseClassExploded);

        $file = $this->readThisFolder($filename.'.json');

        $fileIsParsed = json_encode($file);

        return $fileIsParsed ? $file : false;
    }

    public function generateApiClient(ApiRoute $apiRoute): false|ApiClient
    {
        if (!$json = $this->readJson($apiRoute)) {
            return false;
        }

        $guzzleClient = $this->createStub(Client::class);
        $response = new Response(200, [], $json);

        $guzzleClient
            ->method('request')
            ->willReturn($response)
        ;

        $apiClient = new ApiClient(ApiClient::DEFAULT_API_TOKEN_TEST, ApiClient::DEFAULT_API_URL, $guzzleClient);

        return $apiClient;
    }

    public function makeApiClientRequest(ApiRoute $apiRoute): false|ApiResponse
    {
        if (!$client = $this->generateApiClient($apiRoute)) {
            return false;
        }

        $response = $client->makeRequest($apiRoute);

        return $response;
    }
}
