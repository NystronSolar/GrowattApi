<?php

namespace NystronSolar\GrowattApi\Response;

use NystronSolar\GrowattApi\Entity\Plant;
use NystronSolar\GrowattApi\Helper\TypeHelper;
use Psr\Http\Message\ResponseInterface;

class ApiUserPlantsResponse extends ApiResponse
{
    /** @var Plant[] */
    private array $plants = [];

    /** @param Plant[] $plants */
    public function __construct(ResponseInterface $httpResponse, string $errorMessage, int $errorCode, \stdClass $responseJson, Plant ...$plants)
    {
        parent::__construct($httpResponse, $errorMessage, $errorCode, $responseJson);

        $this->plants = $plants;
    }

    /** @return Plant[] */
    public function getPlants(): array
    {
        return $this->plants;
    }

    public static function generate(ResponseInterface $httpResponse): ApiUserPlantsResponse|false
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
        $rawPlants = TypeHelper::castToArray($data->plants ?? []);

        /** @var Plant[] */
        $plants = [];

        foreach ($rawPlants as $rawPlant) {
            if (
                // Typed Doc blocks are added here for PSALM, when using it outside the If, when creating the User instance
                !TypeHelper::isString(/** @var string $totalEnergy */ $totalEnergy = $rawPlant->total_energy)
                || !TypeHelper::isInt(/** @var int $plantId */ $plantId = $rawPlant->plant_id)
                || !TypeHelper::isString(/** @var string $country */ $country = $rawPlant->country)
                || !TypeHelper::isString(/** @var string $city */ $city = $rawPlant->city)
                || !TypeHelper::isString(/** @var string $imageUrl */ $imageUrl = $rawPlant->image_url, true)
                || !TypeHelper::isString(/** @var string $latitude */ $latitude = $rawPlant->latitude)
                || !TypeHelper::isString(/** @var string $currentPower */ $currentPower = $rawPlant->current_power)
                || !TypeHelper::isString(/** @var string $locale */ $locale = $rawPlant->locale)
                || !TypeHelper::isFloat(/** @var float $peakPower */ $peakPower = $rawPlant->peak_power)
                || !TypeHelper::isString(/** @var string $operator */ $operator = $rawPlant->operator)
                || !TypeHelper::isString(/** @var string $installer */ $installer = $rawPlant->installer)
                || !TypeHelper::isInt(/** @var int $userId */ $userId = $rawPlant->user_id)
                || !TypeHelper::isString(/** @var string $name */ $name = $rawPlant->name)
                || !TypeHelper::isString(/** @var string $createDate */ $createDate = $rawPlant->create_date)
                || !TypeHelper::isInt(/** @var int $status */ $status = $rawPlant->status)
                || !TypeHelper::isString(/** @var string $longitude */ $longitude = $rawPlant->longitude)
            ) {
                return false;
            }

            $plant = new Plant($totalEnergy, $plantId, $country, $city, $imageUrl, $latitude, $currentPower, $locale, (string) $peakPower, $operator, $installer, $userId, $name, $createDate, $status, $longitude);

            $plants[] = $plant;
        }

        return new ApiUserPlantsResponse(
            $httpResponse,
            $errorMessage,
            $errorCode,
            $responseJson,
            ...$plants
        );
    }
}
