<?php

namespace NystronSolar\GrowattApi\Response;

use NystronSolar\GrowattApi\Helper\TypeHelper;

class ApiResponse
{
    private string $errorMessage;

    private int $errorCode;

    public function __construct(string $errorMessage, int $errorCode)
    {
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function hasErrors(): bool
    {
        return 0 !== $this->errorCode;
    }

    public static function generate(object $responseJson): ApiResponse|false
    {
        $errorMessage = TypeHelper::castToString($responseJson->error_msg);
        $errorCode = TypeHelper::castToInt($responseJson->error_code);

        return new ApiResponse($errorMessage, $errorCode);
    }
}
