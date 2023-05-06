<?php

namespace NystronSolar\GrowattApi\Route;

use NystronSolar\GrowattApi\Response\ApiResponse;

abstract class ApiRoute
{
    abstract public static function getDescription(): string;

    abstract public static function getRequestRoute(): string;

    abstract public static function getRequestMethod(): string;

    /**
     * @return class-string<ApiResponse>
     */
    abstract public static function getApiResponse(): string;

    /**
     * @return array<string, string>
     */
    abstract public function getAllParams(): array;
}
