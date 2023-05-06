<?php

namespace NystronSolar\GrowattApi\Route;

use NystronSolar\GrowattApi\Helper\IntHelper;
use NystronSolar\GrowattApi\Response\ApiAllUsersResponse;

final class ApiAllUsersRoute extends ApiRoute
{
    private int $page;
    private int $perPage;

    /**
     * @param int $perPage Maximum 100
     */
    public function __construct(int $page = 1, int $perPage = 20)
    {
        $perPagePositive = IntHelper::negativeToOne($perPage);
        $perPageLimited = IntHelper::limitTo($perPagePositive, 100);

        $this->page = IntHelper::negativeToOne($page);
        $this->perPage = $perPageLimited;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public static function getDescription(): string
    {
        return 'Get a full list of Users under the merchant';
    }

    public static function getRequestRoute(): string
    {
        return 'user/c_user_list';
    }

    public static function getRequestMethod(): string
    {
        return 'GET';
    }

    /**
     * @return class-string<ApiAllUsersResponse>
     */
    public static function getApiResponse(): string
    {
        return ApiAllUsersResponse::class;
    }

    public function getAllParams(): array
    {
        return [
            'page' => strval($this->getPage()),
            'per_page' => strval($this->getPerPage()),
        ];
    }
}
