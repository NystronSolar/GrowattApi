<?php

namespace NystronSolar\GrowattApi;

use GuzzleHttp\Client as GuzzleClient;
use NystronSolar\GrowattApi\Response\ApiResponse;
use NystronSolar\GrowattApi\Route\ApiRoute;

class ApiClient
{
    /** @var string */
    public const DEFAULT_API_URL = 'https://openapi.growatt.com';

    /** @var string */
    public const DEFAULT_API_URL_TEST = 'https://test.growatt.com';

    /** @var string */
    public const DEFAULT_API_TOKEN_TEST = '6eb6f069523055a339d71e5b1f6c88cc';

    /** @var string */
    public const DATE_FORMAT = 'Y-m-d';

    /** @var string */
    public const TIME_FORMAT = 'Y-m-d H:i:s';

    /** @var string */
    public const API_VERSION = 'v1';

    private string $apiToken;

    private string $apiUrl;

    private GuzzleClient $guzzleClient;

    public function __construct(#[\SensitiveParameter] string $apiToken, string $apiUrl = null, GuzzleClient $guzzleClient = null)
    {
        $this->apiToken = $apiToken;
        $this->apiUrl = $apiUrl ?? static::DEFAULT_API_URL;
        $this->guzzleClient = $guzzleClient ?? new GuzzleClient();
    }

    public function generateUrl(ApiRoute $apiRoute): string
    {
        $apiUrl = $this->getApiUrl();
        $apiVersion = self::API_VERSION;
        $route = $apiRoute->getRequestRoute();

        return sprintf('%s/%s/%s', $apiUrl, $apiVersion, $route);
    }

    public function generateOptions(array $formParams = []): array
    {
        $headers = [
            'token' => $this->getApiToken(),
        ];

        $options = [
            'headers' => $headers,
            'form_params' => $formParams,
        ];

        return $options;
    }

    public function makeRequest(ApiRoute $apiRoute, array $params = []): ApiResponse|false
    {
        $options = $this->generateOptions($params);
        $apiRouteMethod = $apiRoute->getRequestMethod();
        $apiResponseClass = $apiRoute->getApiResponse();
        $route = $this->generateUrl($apiRoute);
        $client = $this->getGuzzleClient();

        $response = $client->request($apiRouteMethod, $route, $options);

        $apiResponse = $apiResponseClass::generate($response);

        return $apiResponse;
    }

    public function getApiToken(): string
    {
        return $this->apiToken;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function setApiUrl(string $apiUrl): self
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    public function getGuzzleClient(): GuzzleClient
    {
        return $this->guzzleClient;
    }
}
