<?php

namespace NystronSolar\GrowattApi\Route;

use NystronSolar\GrowattApi\Response\ApiPlantHistoryResponse;

final class ApiPlantHistoryRoute extends ApiRoute
{
    public function getDescription(): string
    {
        return 'Get the historical Power Generation of a Power Station';
    }

    public function getRequestRoute(): string
    {
        return 'plant/energy';
    }

    public function getRequestMethod(): string
    {
        return 'GET';
    }

    /**
     * @return class-string<ApiPlantHistoryResponse>
     */
    public function getApiResponse(): string
    {
        return ApiPlantHistoryResponse::class;
    }
}
