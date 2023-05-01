<?php

namespace NystronSolar\GrowattApi\Response;

use NystronSolar\GrowattApi\Helper\TypeHelper;
use Psr\Http\Message\ResponseInterface;

class ApiResponse
{
    private ResponseInterface $httpResponse;

    private string $errorMessage;

    private int $errorCode;

    private \stdClass $responseJson;

    public function __construct(ResponseInterface $httpResponse, string $errorMessage, int $errorCode, \stdClass $responseJson)
    {
        $this->httpResponse = $httpResponse;
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
        $this->responseJson = $responseJson;
    }

    public function getHttpResponse(): ResponseInterface
    {
        return $this->httpResponse;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function getResponseJson(): \stdClass
    {
        return $this->responseJson;
    }

    public function hasErrors(): bool
    {
        return 0 !== $this->errorCode;
    }

    public static function generate(ResponseInterface $httpResponse): ApiResponse|false
    {
        /** @var \stdClass|null */
        $responseJson = json_decode($httpResponse->getBody()->getContents(), false);

        if (is_null($responseJson)) {
            return false;
        }

        $errorMessage = TypeHelper::castToString($responseJson->error_msg);
        $errorCode = TypeHelper::castToInt($responseJson->error_code);

        return new ApiResponse($httpResponse, $errorMessage, $errorCode, $responseJson);
    }
}
