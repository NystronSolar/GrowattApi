<?php

namespace NystronSolar\GrowattApi\Response;

use NystronSolar\GrowattApi\Entity\User;

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

        /** @var mixed */
        $data = $responseJson->data ?? new \stdClass();
        $data = is_object($data) ? $data : new \stdClass();

        /** @var mixed */
        $count = $data->count ?? 0;
        $count = is_int($count) ? $count : 0;

        /** @var mixed */
        $users = $data->c_user ?? [];
        /** @var object[] */
        $rawUsers = is_array($users) ? $users : [];

        /** @var User[] */
        $users = [];

        foreach ($rawUsers as $rawUser) {
            $id = $rawUser->c_user_id;
            $name = $rawUser->c_user_name;
            $email = $rawUser->c_user_email;
            $telephone = $rawUser->c_user_tel;
            $registerTime = $rawUser->c_user_regtime;
            if (
                !is_int($id) ||
                !is_string($name) ||
                !is_string($email) ||
                !is_string($telephone) ||
                !is_string($registerTime)
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
