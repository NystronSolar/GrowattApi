<?php

namespace NystronSolar\GrowattApi\Response;

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
        /** @var mixed */
        $errorMessage = $responseJson->error_msg ?? '';
        $errorMessage = is_string($errorMessage) ? $errorMessage : '';

        /** @var mixed */
        $errorCode = $responseJson->error_code ?? 0;
        $errorCode = is_int($errorCode) ? $errorCode : 0;

        return new ApiResponse($errorMessage, $errorCode);
    }
}
