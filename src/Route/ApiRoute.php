<?php

namespace NystronSolar\GrowattApi\Route;

use NystronSolar\GrowattApi\Response\ApiResponse;

abstract class ApiRoute
{
    abstract public function getDescription(): string;

    abstract public function getRequestRoute(): string;

    abstract public function getRequestMethod(): string;

    /**
     * @return class-string<ApiResponse>
     */
    abstract public function getApiResponse(): string;
}
