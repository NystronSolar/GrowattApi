<?php

namespace NystronSolar\GrowattApi\Response;

use NystronSolar\GrowattApi\Entity\User;
use NystronSolar\GrowattApi\Helper\TypeHelper;

class ApiAllUsersResponse extends ApiResponse
{
    private int $dataCount = 0;

    /** @var User[] */
    private array $users = [];

    /** @param User[] $users */
    public function __construct(string $errorMessage, int $errorCode, User ...$users)
    {
        parent::__construct($errorMessage, $errorCode);

        $this->users = $users;
        $this->dataCount = count($users);
    }

    public function getDataCount(): int
    {
        return $this->dataCount;
    }

    /** @return User[] */
    public function getUsers(): array
    {
        return $this->users;
    }

    public static function generate(object $responseJson): ApiAllUsersResponse|false
    {
        $primitiveApiResponse = parent::generate($responseJson);
        if (!$primitiveApiResponse) {
            return false;
        }

        $errorMessage = $primitiveApiResponse->getErrorMessage();
        $errorCode = $primitiveApiResponse->getErrorCode();

        $data = TypeHelper::castToObject($responseJson->data);
        $count = TypeHelper::castToInt($data->count);
        /** @var object[] */
        $rawUsers = TypeHelper::castToArray($data->c_user);

        /** @var User[] */
        $users = [];

        foreach ($rawUsers as $rawUser) {
            if (
                // Typed Doc blocks are added here for PSALM, when using it outside the If, when creating the User instance
                !TypeHelper::isInt(/** @var int $id */ $id = $rawUser->c_user_id) ||
                !TypeHelper::isString(/** @var string $name */ $name = $rawUser->c_user_name) ||
                !TypeHelper::isString(/** @var string $email */ $email = $rawUser->c_user_email) ||
                !TypeHelper::isString(/** @var string $telephone */ $telephone = $rawUser->c_user_tel) ||
                !TypeHelper::isString(/** @var string $registerTime */ $registerTime = $rawUser->c_user_regtime)
            ) {
                return false;
            }

            $user = new User($id, $name, $email, $telephone, $registerTime);

            $users[] = $user;
        }

        if (count($users) !== $count) {
            return false;
        }

        return new ApiAllUsersResponse(
            $errorMessage,
            $errorCode,
            ...$users
        );
    }
}
