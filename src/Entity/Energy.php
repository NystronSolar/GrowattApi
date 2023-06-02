<?php

namespace NystronSolar\GrowattApi\Entity;

use NystronSolar\GrowattApi\Client\ApiClientInterface;

/**
 * @property numeric-string $generation
 *
 * @method numeric-string getGeneration()
 */
class Energy
{
    private \DateTimeInterface $date;

    private string $generation;

    /**
     * @param numeric-string $generation
     */
    public function __construct(string $date, string $generation)
    {
        $this->generation = $generation;

        $dateObj = \DateTimeImmutable::createFromFormat(
            ApiClientInterface::DATE_FORMAT,
            $date
        );

        if (!$dateObj) {
            throw new \Exception(sprintf('Time Format cannot be created with "%s" format and "%s" value', ApiClientInterface::TIME_FORMAT, $date));
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
