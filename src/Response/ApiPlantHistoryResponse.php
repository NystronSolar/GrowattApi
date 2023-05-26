<?php

namespace NystronSolar\GrowattApi\Response;

use NystronSolar\GrowattApi\Entity\Energy;
use NystronSolar\GrowattApi\Entity\TimeUnit;
use Psr\Http\Message\ResponseInterface;

class ApiPlantHistoryResponse extends ApiResponse
{
    private TimeUnit $timeUnit = TimeUnit::Day;

    /** @var Energy[] */
    private array $energies = [];

    /** @param Energy[] $energies */
    public function __construct(ResponseInterface $httpResponse, string $errorMessage, int $errorCode, TimeUnit $timeUnit, \stdClass $responseJson, Energy ...$energies)
    {
        parent::__construct($httpResponse, $errorMessage, $errorCode, $responseJson);

        $this->energies = $energies;
        $this->timeUnit = $timeUnit;
    }

    public function getTimeUnit(): TimeUnit
    {
        return $this->timeUnit;
    }

    /** @return Energy[] */
    public function getEnergies(): array
    {
        return $this->energies;
    }

    public static function generate(ResponseInterface $httpResponse): ApiPlantHistoryResponse|false
    {
        $primitiveApiResponse = parent::generate($httpResponse);
        if (!$primitiveApiResponse) {
            return false;
        }

        $responseJson = $primitiveApiResponse->getResponseJson();
        $errorMessage = $primitiveApiResponse->getErrorMessage();
        $errorCode = $primitiveApiResponse->getErrorCode();

        /** @psalm-var mixed */
        $data = $responseJson->data ?? new \stdClass();
        $data = is_object($data) ? $data : new \stdClass();

        /** @psalm-var mixed */
        $timeUnit = $data->timeUnit ?? '';
        $timeUnit = is_string($timeUnit) ? $timeUnit : '';
        $timeUnit = TimeUnit::tryFrom($timeUnit);
        if (is_null($timeUnit)) {
            $timeUnit = TimeUnit::Day;
        }

        /** @psalm-var mixed */
        $energies = $data->energys ?? [];
        /** @var object[] */
        $rawEnergies = is_array($energies) ? $energies : [];

        /** @var Energy[] */
        $energies = [];

        foreach ($rawEnergies as $rawEnergy) {
            $date = $rawEnergy->date;
            $generation = $rawEnergy->energy;
            if (
                !is_string($date)
                || !is_string($generation)
            ) {
                return false;
            }

            $energy = new Energy($date, $generation);

            $energies[] = $energy;
        }

        return new ApiPlantHistoryResponse(
            $httpResponse,
            $errorMessage,
            $errorCode,
            $timeUnit,
            $responseJson,
            ...$energies
        );
    }
}
