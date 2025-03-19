<?php

namespace NystronSolar\GrowattApi\Entity;

use NystronSolar\GrowattApi\Client\ApiClientInterface;

class Plant
{
    private string $totalEnergy;

    private int $plantId;

    private string $country;

    private string $city;

    private ?string $imageUrl;

    private string $latitude;

    private string $currentPower;

    private string $locale;

    private string $peakPower;

    private int $userId;

    private string $name;

    private \DateTimeInterface $createDate;

    private int $status;

    private string $longitude;

    public function __construct(string $totalEnergy, int $plantId, string $country, string $city, ?string $imageUrl, string $latitude, string $currentPower, string $locale, string $peakPower, int $userId, string $name, string $createDate, int $status, string $longitude)
    {
        $this->totalEnergy = $totalEnergy;
        $this->plantId = $plantId;
        $this->country = $country;
        $this->city = $city;
        $this->imageUrl = $imageUrl;
        $this->latitude = $latitude;
        $this->currentPower = $currentPower;
        $this->locale = $locale;
        $this->peakPower = $peakPower;
        $this->userId = $userId;
        $this->name = $name;
        $this->status = $status;
        $this->longitude = $longitude;

        $createDateObj = \DateTimeImmutable::createFromFormat(
            ApiClientInterface::DATE_FORMAT,
            $createDate
        );

        if (!$createDateObj) {
            throw new \Exception(sprintf('Time Format cannot be created with "%s" format and "%s" value', ApiClientInterface::TIME_FORMAT, $createDate));
        }

        $this->createDate = $createDateObj;
    }

    public function getTotalEnergy(): string
    {
        return $this->totalEnergy;
    }

    public function getPlantId(): int
    {
        return $this->plantId;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getCurrentPower(): string
    {
        return $this->currentPower;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getPeakPower(): string
    {
        return $this->peakPower;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreateDate(): \DateTimeInterface
    {
        return $this->createDate;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }
}
