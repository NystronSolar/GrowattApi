<?php

namespace NystronSolar\GrowattApi\Route;

use NystronSolar\GrowattApi\Response\ApiCheckUserResponse;

final class ApiCheckUserRoute extends ApiRoute
{
    private string $userName;

    public function __construct(string $userName)
    {
        $this->userName = $userName;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public static function getDescription(): string
    {
        return 'Check if the User Name already exists';
    }

    public static function getRequestRoute(): string
    {
        return 'user/check_user';
    }

    public static function getRequestMethod(): string
    {
        return 'POST';
    }

    /**
     * @return class-string<ApiCheckUserResponse>
     */
    public static function getApiResponse(): string
    {
        return ApiCheckUserResponse::class;
    }

    public function getAllParams(): array
    {
        return [
            'user_name' => $this->getUserName(),
        ];
    }
}
