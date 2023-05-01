<?php

namespace NystronSolar\GrowattApi\Response;

use NystronSolar\GrowattApi\Entity\Plant;
use NystronSolar\GrowattApi\Helper\TypeHelper;

class ApiUserPlantsResponse extends ApiResponse
{
    private int $dataCount = 0;

    /** @var Plant[] */
    private array $plants = [];

    /** @param Plant[] $plants */
    public function __construct(string $errorMessage, int $errorCode, Plant ...$plants)
    {
        parent::__construct($errorMessage, $errorCode);

        $this->plants = $plants;
        $this->dataCount = count($plants);
    }

    public function getDataCount(): int
    {
        return $this->dataCount;
    }

    /** @return Plant[] */
    public function getPlants(): array
    {
        return $this->plants;
    }

    public static function generate(object $responseJson): ApiUserPlantsResponse|false
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
        $rawPlants = TypeHelper::castToArray($data->plants);

        /** @var Plant[] */
        $plants = [];

        foreach ($rawPlants as $rawPlant) {
            if (
                // Typed Doc blocks are added here for PSALM, when using it outside the If, when creating the User instance
                !TypeHelper::isString(/** @var string $totalEnergy */ $totalEnergy = $rawPlant->total_energy) ||
                !TypeHelper::isInt(/** @var int $plantId */ $plantId = $rawPlant->plant_id) ||
                !TypeHelper::isString(/** @var string $country */ $country = $rawPlant->country) ||
                !TypeHelper::isString(/** @var string $city */ $city = $rawPlant->city) ||
                !TypeHelper::isString(/** @var string $imageUrl */ $imageUrl = $rawPlant->image_url, true) ||
                !TypeHelper::isString(/** @var string $latitude */ $latitude = $rawPlant->latitude) ||
                !TypeHelper::isString(/** @var string $currentPower */ $currentPower = $rawPlant->current_power) ||
                !TypeHelper::isString(/** @var string $locale */ $locale = $rawPlant->locale) ||
                !TypeHelper::isFloat(/** @var float $peakPower */ $peakPower = $rawPlant->peak_power) ||
                !TypeHelper::isString(/** @var string $operator */ $operator = $rawPlant->operator) ||
                !TypeHelper::isString(/** @var string $installer */ $installer = $rawPlant->installer) ||
                !TypeHelper::isInt(/** @var int $userId */ $userId = $rawPlant->user_id) ||
                !TypeHelper::isString(/** @var string $name */ $name = $rawPlant->name) ||
                !TypeHelper::isString(/** @var string $createDate */ $createDate = $rawPlant->create_date) ||
                !TypeHelper::isInt(/** @var int $status */ $status = $rawPlant->status) ||
                !TypeHelper::isString(/** @var string $longitude */ $longitude = $rawPlant->longitude)
            ) {
                return false;
            }

            $plant = new Plant($totalEnergy, $plantId, $country, $city, $imageUrl, $latitude, $currentPower, $locale, (string) $peakPower, $operator, $installer, $userId, $name, $createDate, $status, $longitude);

            $plants[] = $plant;
        }

        if (count($plants) !== $count) {
            return false;
        }

        return new ApiUserPlantsResponse(
            $errorMessage,
            $errorCode,
            ...$plants
        );
    }
}
