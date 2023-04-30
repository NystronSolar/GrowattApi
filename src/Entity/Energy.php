<?php

namespace NystronSolar\GrowattApi\Entity;

use NystronSolar\GrowattApi\ApiClient;

class Energy
{
    private \DateTimeInterface $date;

    private string $generation;

    public function __construct(string $date, string $generation)
    {
        $this->generation = $generation;

        $dateObj = \DateTimeImmutable::createFromFormat(
            ApiClient::DATE_FORMAT,
            $date
        );

        if (!$dateObj) {
            throw new \Exception(sprintf('Time Format cannot be created with "%s" format and "%s" value', ApiClient::TIME_FORMAT, $date));
        }

        $this->date = $dateObj;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getGeneration(): string
    {
        return $this->generation;
    }
}
