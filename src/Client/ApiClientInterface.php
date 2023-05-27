<?php

namespace NystronSolar\GrowattApi\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use NystronSolar\GrowattApi\Entity\TimeUnit;
use NystronSolar\GrowattApi\Response\ApiAllUsersResponse;
use NystronSolar\GrowattApi\Response\ApiCheckUserExistsResponse;
use NystronSolar\GrowattApi\Response\ApiPlantHistoryResponse;
use NystronSolar\GrowattApi\Response\ApiUserPlantsResponse;
use Psr\Http\Message\ResponseInterface;

interface ApiClientInterface
{
    /** @var string */
    public const DATE_FORMAT = 'Y-m-d';

    /** @var string */
    public const TIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @param non-empty-string $apiToken
     */
    public function __construct(string $apiToken, ClientInterface $httpClient = new Client());

    public function getHttpClient(): ClientInterface;

    /**
     * @return non-empty-string
     */
    public function getApiToken(): string;

    /**
     * @param array<non-empty-string, non-empty-string|int> $params
     */
    public function makeRequest(string $method, string $route, array $params): ResponseInterface;

    /**
     * @param positive-int $page
     * @param int<1, 100>  $perPage
     */
    public function getAllUsersRequest(int $page = 1, int $perPage = 20): ApiAllUsersResponse|false;

    /**
     * @param non-empty-string $userName
     */
    public function checkUserExistsRequest(string $userName): ApiCheckUserExistsResponse|false;

    /**
     * @param positive-int $page
     * @param int<1, 7>    $intervalDays
     * @param int<1, 100>  $perPage
     */
    public function getPlantHistoryRequest(int $plantId, TimeUnit $timeUnit, \DateTimeImmutable $startDate, int $intervalDays = 7, int $page = 1, int $perPage = 20): ApiPlantHistoryResponse|false;

    /**
     * @param non-empty-string $userName
     * @param positive-int     $page
     * @param int<1, 100>      $perPage
     */
    public function getUserPlantsRequest(string $userName, int $page = 1, int $perPage = 20): ApiUserPlantsResponse|false;
}
