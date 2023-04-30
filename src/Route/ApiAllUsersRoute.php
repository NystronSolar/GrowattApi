<?php

namespace NystronSolar\GrowattApi\Route;

use NystronSolar\GrowattApi\Response\ApiAllUsersResponse;

final class ApiAllUsersRoute extends ApiRoute
{
    public function getDescription(): string
    {
        return 'Get a full list of Users under the merchant';
    }

    public function getRequestRoute(): string
    {
        return 'user/c_user_list';
    }

    public function getRequestMethod(): string
    {
        return 'GET';
    }

    /**
     * @return class-string<ApiAllUsersResponse>
     */
    public function getApiResponse(): string
    {
        return ApiAllUsersResponse::class;
    }
}
