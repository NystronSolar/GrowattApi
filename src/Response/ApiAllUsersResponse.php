<?php

namespace NystronSolar\GrowattApi\Response;

use NystronSolar\GrowattApi\Entity\User;
use NystronSolar\GrowattApi\Helper\TypeHelper;
use Psr\Http\Message\ResponseInterface;

class ApiAllUsersResponse extends ApiResponse
{
    /** @var User[] */
    private array $users = [];

    /** @param User[] $users */
    public function __construct(ResponseInterface $httpResponse, string $errorMessage, int $errorCode, \stdClass $responseJson, User ...$users)
    {
        parent::__construct($httpResponse, $errorMessage, $errorCode, $responseJson);

        $this->users = $users;
    }

    /** @return User[] */
    public function getUsers(): array
    {
        return $this->users;
    }

    public static function generate(ResponseInterface $httpResponse): ApiAllUsersResponse|false
    {
        $primitiveApiResponse = parent::generate($httpResponse);
        if (!$primitiveApiResponse) {
            return false;
        }

        $responseJson = $primitiveApiResponse->getResponseJson();
        $errorMessage = $primitiveApiResponse->getErrorMessage();
        $errorCode = $primitiveApiResponse->getErrorCode();

        $data = TypeHelper::castToObject($responseJson->data);
        /** @var object[] */
        $rawUsers = TypeHelper::castToArray($data->c_user);

        /** @var User[] */
        $users = [];

        foreach ($rawUsers as $rawUser) {
            if (
                // Typed Doc blocks are added here for PSALM, when using it outside the If, when creating the User instance
                !TypeHelper::isInt(/** @var int $id */ $id = $rawUser->c_user_id)
                || !TypeHelper::isString(/** @var string $name */ $name = $rawUser->c_user_name)
                || !TypeHelper::isString(/** @var string $email */ $email = $rawUser->c_user_email)
                || !TypeHelper::isString(/** @var string $telephone */ $telephone = $rawUser->c_user_tel)
                || !TypeHelper::isString(/** @var string $registerTime */ $registerTime = $rawUser->c_user_regtime)
            ) {
                return false;
            }

            $user = new User($id, $name, $email, $telephone, $registerTime);

            $users[] = $user;
        }

        return new ApiAllUsersResponse(
            $httpResponse,
            $errorMessage,
            $errorCode,
            $responseJson,
            ...$users,
        );
    }
}
