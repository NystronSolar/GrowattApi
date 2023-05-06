<?php

namespace NystronSolar\GrowattApi\Route;

use NystronSolar\GrowattApi\Helper\IntHelper;
use NystronSolar\GrowattApi\Response\ApiUserPlantsResponse;

final class ApiUserPlantsRoute extends ApiRoute
{
    private string $userName;

    private int $page;

    private int $perPage;

    /**
     * @param int $perPage Maximum 100
     */
    public function __construct(string $userName, int $page = 1, int $perPage = 20)
    {
        $perPagePositive = IntHelper::negativeToOne($perPage);
        $perPageLimited = IntHelper::limitTo($perPagePositive, 100);

        $this->page = IntHelper::negativeToOne($page);
        $this->perPage = $perPageLimited;
        $this->userName = $userName;
    }

    public function getUserName(): string
    {
        return $this->userName;
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
        return 'Get the power station list of a user';
    }

    public static function getRequestRoute(): string
    {
        return 'plant/user_plant_list';
    }

    public static function getRequestMethod(): string
    {
        return 'POST';
    }

    /**
     * @return class-string<ApiUserPlantsResponse>
     */
    public static function getApiResponse(): string
    {
        return ApiUserPlantsResponse::class;
    }

    public function getAllParams(): array
    {
        return [
            'user_name' => $this->getUserName(),
            'page' => strval($this->getPage()),
            'perpage' => strval($this->getPerPage()),
        ];
    }
}
