<?php

namespace NystronSolar\GrowattApi\Response;

use Psr\Http\Message\ResponseInterface;

class ApiCheckUserExistsResponse extends ApiResponse
{
    private bool $userExists;

    public function __construct(ResponseInterface $httpResponse, string $errorMessage, int $errorCode, \stdClass $responseJson, bool $userExists)
    {
        parent::__construct($httpResponse, $errorMessage, $errorCode, $responseJson);

        $this->userExists = $userExists;
    }

    public function userExists(): bool
    {
        return $this->userExists;
    }

    public static function generate(ResponseInterface $httpResponse): ApiCheckUserExistsResponse|false
    {
        $primitiveApiResponse = parent::generate($httpResponse);
        if (!$primitiveApiResponse) {
            return false;
        }

        $responseJson = $primitiveApiResponse->getResponseJson();
        $errorMessage = $primitiveApiResponse->getErrorMessage();
        $errorCode = $primitiveApiResponse->getErrorCode();

        $userExists = 10003 === $errorCode ? true : false;
        $errorCode = $userExists ? 0 : $errorCode;
        $errorMessage = $userExists ? '' : $errorMessage;

        return new ApiCheckUserExistsResponse(
            $httpResponse,
            $errorMessage,
            $errorCode,
            $responseJson,
            $userExists
        );
    }
}
