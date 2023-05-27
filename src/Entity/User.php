<?php

namespace NystronSolar\GrowattApi\Entity;

use NystronSolar\GrowattApi\Client\ApiClientInterface;

class User
{
    private int $id;

    private string $name;

    private string $email;

    private string $telephone;

    private \DateTimeInterface $registerTime;

    public function __construct(int $id, string $name, string $email, string $telephone, string $registerTime)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->telephone = $telephone;

        $registerTimeObj = \DateTimeImmutable::createFromFormat(
            ApiClientInterface::TIME_FORMAT,
            $registerTime
        );

        if (!$registerTimeObj) {
            throw new \Exception(sprintf('Time Format cannot be created with "%s" format and "%s" value', ApiClientInterface::TIME_FORMAT, $registerTime));
        }

        $this->registerTime = $registerTimeObj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getRegisterTime(): \DateTimeInterface
    {
        return $this->registerTime;
    }
}
