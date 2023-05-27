<?php

namespace NystronSolar\GrowattApi\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use NystronSolar\GrowattApi\Entity\TimeUnit;
use NystronSolar\GrowattApi\Response\ApiAllUsersResponse;
use NystronSolar\GrowattApi\Response\ApiCheckUserExistsResponse;
use NystronSolar\GrowattApi\Response\ApiPlantHistoryResponse;
use NystronSolar\GrowattApi\Response\ApiUserPlantsResponse;
use Psr\Http\Message\ResponseInterface;

class FakeApiClient implements ApiClientInterface
{
    private ClientInterface $httpClient;

    /**
     * @var non-empty-string
     */
    private string $apiToken;

    /**
     * @param non-empty-string $apiToken
     */
    public function __construct(string $apiToken = 'a', ClientInterface $httpClient = new Client())
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

    /**
     * @param array<non-empty-string, non-empty-string|int> $params
     */
    public function makeRequest(string $method, string $route, array $params): ResponseInterface
    {
        return new Response();
    }

    /**
     * @param positive-int $page
     * @param int<1, 100>  $perPage
     */
    public function getAllUsersRequest(int $page = 1, int $perPage = 20): ApiAllUsersResponse|false
    {
        $response = new Response(200, [], '{"error_msg": "","data": {"c_user": [{"c_user_id": 1,"c_user_regtime": "2023-01-01 01:01:01","c_user_tel": "0123456789","c_user_email": "tim@email.com","c_user_name": "Tim Goland"},{"c_user_id": 2,"c_user_regtime": "2023-01-01 01:01:01","c_user_tel": "0123456789","c_user_email": "carpi@email.com","c_user_name": "Leo de Carpi"},{"c_user_id": 3,"c_user_regtime": "2023-01-01 01:01:01","c_user_tel": "0123456789","c_user_email": "max@email.com","c_user_name": "Max Verstop"},{"c_user_id": 4,"c_user_regtime": "2023-01-01 01:01:01","c_user_tel": "0123456789","c_user_email": "drugo@email.com","c_user_name": "Folipe Drugo"}],"count": 4},"error_code": 0}');

        $apiResponse = ApiAllUsersResponse::generate($response);

        return $apiResponse;
    }

    /**
     * @param non-empty-string $userName
     */
    public function checkUserExistsRequest(string $userName): ApiCheckUserExistsResponse|false
    {
        $userExists =
            'Tim Goland' === $userName
            || 'Leo de Carpi' === $userName
            || 'Max Verstop' === $userName
            || 'Folipe Drugo' === $userName
        ;

        $responseBody = $userExists ? '{"error_msg":"error_Username already exists","data":"","error_code":10003}' : '{"error_msg":"","data":"","error_code":0}';
        $response = new Response(200, [], $responseBody);

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
        $responseBody = match ($plantId) {
            1 => '{"error_msg": "","data": {"energys": [{"date": "2023-01-01","energy": "11.3"},{"date": "2023-01-02","energy": "13.5"},{"date": "2023-01-03","energy": "19.6"},{"date": "2023-01-04","energy": "12.3"},{"date": "2023-01-05","energy": "23.1"},{"date": "2023-01-06","energy": "13.7"},{"date": "2023-01-07","energy": "15.3"}],"count": 7,"time_unit": "day"},"error_code": 0}',
            2 => '{"error_msg": "","data": {"energys": [{"date": "2023-01-01","energy": "23.4"},{"date": "2023-01-02","energy": "23.2"},{"date": "2023-01-03","energy": "23.1"},{"date": "2023-01-04","energy": "15.7"},{"date": "2023-01-05","energy": "19.2"},{"date": "2023-01-06","energy": "16.1"},{"date": "2023-01-07","energy": "17.7"}],"count": 7,"time_unit": "day"},"error_code": 0}',
            3 => '{"error_msg": "","data": {"energys": [{"date": "2023-01-01","energy": "32.6"},{"date": "2023-01-02","energy": "21.6"},{"date": "2023-01-03","energy": "32.1"},{"date": "2023-01-04","energy": "11.3"},{"date": "2023-01-05","energy": "14.7"},{"date": "2023-01-06","energy": "21.6"},{"date": "2023-01-07","energy": "14.9"}],"count": 7,"time_unit": "day"},"error_code": 0}',
            4 => '{"error_msg": "","data": {"energys": [{"date": "2023-01-01","energy": "12.5"},{"date": "2023-01-02","energy": "10.9"},{"date": "2023-01-03","energy": "12.3"},{"date": "2023-01-04","energy": "19.5"},{"date": "2023-01-05","energy": "12.6"},{"date": "2023-01-06","energy": "15.7"},{"date": "2023-01-07","energy": "18.7"}],"count": 7,"time_unit": "day"},"error_code": 0}',
            default => '{"error_msg":"error_Plant does not exist","data":"","error_code":10002}'
        };

        $response = new Response(200, [], $responseBody);

        $apiResponse = ApiPlantHistoryResponse::generate($response);

        return $apiResponse;
    }

    /**
     * @param non-empty-string $userName
     * @param positive-int     $page
     */
    public function getUserPlantsRequest(string $userName, int $page = 1, int $perPage = 20): ApiUserPlantsResponse|false
    {
        $responseBody = match ($userName) {
            'Tim Goland' => '{"error_msg": "","data": {"plants": [{"total_energy": "10000","plant_id": 1,"country": "Brazil","latitude_f": null,"latitude_d": null,"city": "Pelotas","image_url": null,"latitude": "-10.123456","current_power": "300.5","locale": "en-US","peak_power": 10.3,"operator": "0","installer": "0","user_id": 1,"name": "Tim Goland Plant","create_date": "2023-01-01","status": 1,"longitude": "-50.123456"}],"count": 1},"error_code": 0}',
            'Leo de Carpi' => '{"error_msg": "","data": {"plants": [{"total_energy": "20000","plant_id": 2,"country": "Brazil","latitude_f": null,"latitude_d": null,"city": "Curitiba","image_url": null,"latitude": "-20.123456","current_power": "400.7","locale": "en-US","peak_power": 20.5,"operator": "0","installer": "0","user_id": 2,"name": "Leo de Carpi Plant","create_date": "2023-01-01","status": 1,"longitude": "-30.123456"}],"count": 1},"error_code": 0}',
            'Max Verstop' => '{"error_msg": "","data": {"plants": [{"total_energy": "30000","plant_id": 3,"country": "Brazil","latitude_f": null,"latitude_d": null,"city": "Salvador","image_url": null,"latitude": "-30.123456","current_power": "500.3","locale": "en-US","peak_power": 30.7,"operator": "0","installer": "0","user_id": 3,"name": "Max Verstop Plant","create_date": "2023-01-01","status": 1,"longitude": "-70.123456"}],"count": 1},"error_code": 0}',
            'Folipe Drugo' => '{"error_msg": "","data": {"plants": [{"total_energy": "40000","plant_id": 4,"country": "Brazil","latitude_f": null,"latitude_d": null,"city": "Recife","image_url": null,"latitude": "-40.123456","current_power": "600.2","locale": "en-US","peak_power": 40.9,"operator": "0","installer": "0","user_id": 4,"name": "Folipe Drugo Plant","create_date": "2023-01-01","status": 1,"longitude": "-20.123456"}],"count": 1},"error_code": 0}',
            default => '{"error_msg":"error_permission_denied","data":"","error_code":10011}'
        };

        $response = new Response(200, [], $responseBody);

        $apiResponse = ApiUserPlantsResponse::generate($response);

        return $apiResponse;
    }
}
