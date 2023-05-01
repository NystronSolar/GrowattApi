<?php

namespace NystronSolar\GrowattApi\Route;

use NystronSolar\GrowattApi\Response\ApiUserPlantsResponse;

final class ApiUserPlantsRoute extends ApiRoute
{
    public function getDescription(): string
    {
        return 'Get the power station list of a user';
    }

    public function getRequestRoute(): string
    {
        return 'plant/user_plant_list';
    }

    public function getRequestMethod(): string
    {
        return 'POST';
    }

    /**
     * @return class-string<ApiUserPlantsResponse>
     */
    public function getApiResponse(): string
    {
        return ApiUserPlantsResponse::class;
    }
}
