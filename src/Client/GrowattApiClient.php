<?php

namespace NystronSolar\GrowattApi\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use NystronSolar\GrowattApi\Entity\TimeUnit;
use NystronSolar\GrowattApi\Helper\IntHelper;
use NystronSolar\GrowattApi\Response\ApiAllUsersResponse;
use NystronSolar\GrowattApi\Response\ApiCheckUserExistsResponse;
use NystronSolar\GrowattApi\Response\ApiPlantHistoryResponse;
use NystronSolar\GrowattApi\Response\ApiUserPlantsResponse;
use Psr\Http\Message\ResponseInterface;

class GrowattApiClient implements ApiClientInterface
{
    private ClientInterface $httpClient;

    /**
     * @var non-empty-string
     */
    private string $apiToken;

    /**
     * @param non-empty-string $apiToken
     */
    public function __construct(string $apiToken, ClientInterface $httpClient = new Client())
    {
        $this->apiToken = $apiToken;
        $this->httpClient = $httpClient;
    }

    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * @return non-empty-string
     */
    public function getApiToken(): string
    {
        return $this->apiToken;
    }

    public function validatePage(int $rawPage): int
    {
        $page = IntHelper::negativeToOne($rawPage);

        return $page;
    }

    public function validatePerPage(int $rawPerPage): int
    {
        $perPage = IntHelper::negativeToOne($rawPerPage);
        $perPage = IntHelper::limitTo($perPage, 100);

        return $perPage;
    }

    /**
     * @param array<non-empty-string, non-empty-string|int> $params
     *
     * @return array{headers: array{token: non-empty-string}, query: array<non-empty-string, non-empty-string|int>}
     */
    public function generateOptions(array $params): array
    {
        $headers = [
            'token' => $this->getApiToken(),
        ];

        $options = [
            'headers' => $headers,
            'query' => $params,
        ];

        return $options;
    }

    /**
     * @param array<non-empty-string, non-empty-string|int> $params
     */
    public function makeRequest(string $method, string $route, array $params): ResponseInterface
    {
        $apiUrl = 'https://openapi.growatt.com';
        $apiVersion = 'v1';

        $uri = sprintf('%s/%s/%s', $apiUrl, $apiVersion, $route);
        $options = $this->generateOptions($params);

        $response = $this->getHttpClient()->request($method, $uri, $options);

        return $response;
    }

    /**
     * @param positive-int $page
     * @param int<1, 100>  $perPage
     */
    public function getAllUsersRequest(int $page = 1, int $perPage = 20): ApiAllUsersResponse|false
    {
        $response = $this->makeRequest(
            'GET',
            'user/c_user_list',
            [
                'page' => $this->validatePage($page),
                'perpage' => $this->validatePerPage($perPage),
            ],
        );

        $apiResponse = ApiAllUsersResponse::generate($response);

        return $apiResponse;
    }

    /**
     * @param non-empty-string $userName
     */
    public function checkUserExistsRequest(string $userName): ApiCheckUserExistsResponse|false
    {
        $response = $this->makeRequest(
            'POST',
            'user/check_user',
            [
                'user_name' => $userName,
            ],
        );

        $apiResponse = ApiCheckUserExistsResponse::generate($response);

        return $apiResponse;
    }

    /**
     * @param positive-int $page
     * @param int<1, 7>    $intervalDays
     * @param int<1, 100>  $perPage
     */
    public function getPlantHistoryRequest(int $plantId, TimeUnit $timeUnit, \DateTimeImmutable $startDate, int $intervalDays = 7, int $page = 1, int $perPage = 20): ApiPlantHistoryResponse|false
    {
        $intervalDaysPositive = IntHelper::negativeToOne($intervalDays);
        $intervalDaysLimited = IntHelper::limitTo($intervalDaysPositive, 7);

        $intervalDaysObject = new \DateInterval(sprintf('P%sD', $intervalDaysLimited));
        $endDate = $startDate->add($intervalDaysObject);

        $response = $this->makeRequest(
            'GET',
            'plant/energy',
            [
                'plant_id' => $plantId,
                'start_date' => $startDate->format(self::DATE_FORMAT),
                'end_date' => $endDate->format(self::DATE_FORMAT),
                'time_unit' => $timeUnit->value,
                'page' => $this->validatePage($page),
                'perpage' => $this->validatePerPage($perPage),
            ],
        );

        $apiResponse = ApiPlantHistoryResponse::generate($response);

        return $apiResponse;
    }

    /**
     * @param non-empty-string $userName
     * @param positive-int     $page
     */
    public function getUserPlantsRequest(string $userName, int $page = 1, int $perPage = 20): ApiUserPlantsResponse|false
    {
        $response = $this->makeRequest(
            'POST',
            'plant/user_plant_list',
            [
                'user_name' => $userName,
                'page' => $this->validatePage($page),
                'perpage' => $this->validatePerPage($perPage),
            ],
        );

        $apiResponse = ApiUserPlantsResponse::generate($response);

        return $apiResponse;
    }
}
