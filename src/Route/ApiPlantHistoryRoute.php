<?php

namespace NystronSolar\GrowattApi\Route;

use NystronSolar\GrowattApi\ApiClient;
use NystronSolar\GrowattApi\Entity\TimeUnit;
use NystronSolar\GrowattApi\Helper\IntHelper;
use NystronSolar\GrowattApi\Response\ApiPlantHistoryResponse;

final class ApiPlantHistoryRoute extends ApiRoute
{
    private int $plantId;

    private \DateTimeImmutable $startDate;

    private \DateTimeImmutable $endDate;

    private int $intervalDays;

    private TimeUnit $timeUnit;

    private int $page;

    private int $perPage;

    /**
     * @param int $intervalDays Maximum 7
     * @param int $perPage      Maximum 100
     */
    public function __construct(int $plantId, TimeUnit $timeUnit, \DateTimeImmutable $startDate, int $intervalDays = 7, int $page = 1, int $perPage = 20)
    {
        $perPagePositive = IntHelper::negativeToOne($perPage);
        $perPageLimited = IntHelper::limitTo($perPagePositive, 100);

        $intervalDaysPositive = IntHelper::negativeToOne($intervalDays);
        $intervalDaysLimited = IntHelper::limitTo($intervalDaysPositive, 7);

        $intervalDaysObject = new \DateInterval(sprintf('P%sD', $intervalDaysLimited));
        $endDate = $startDate->add($intervalDaysObject);

        $this->plantId = IntHelper::negativeToOne($plantId);
        $this->page = IntHelper::negativeToOne($page);
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->intervalDays = $intervalDaysLimited;
        $this->timeUnit = $timeUnit;
        $this->perPage = $perPageLimited;
    }

    public function getPlantId(): int
    {
        return $this->plantId;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getIntervalDays(): int
    {
        return $this->intervalDays;
    }

    public function getTimeUnit(): TimeUnit
    {
        return $this->timeUnit;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public static function getDescription(): string
    {
        return 'Get the historical Power Generation of a Power Station';
    }

    public static function getRequestRoute(): string
    {
        return 'plant/energy';
    }

    public static function getRequestMethod(): string
    {
        return 'GET';
    }

    /**
     * @return class-string<ApiPlantHistoryResponse>
     */
    public static function getApiResponse(): string
    {
        return ApiPlantHistoryResponse::class;
    }

    public function getAllParams(): array
    {
        return [
            'plant_id' => strval($this->getPlantId()),
            'start_date' => $this->getStartDate()->format(ApiClient::DATE_FORMAT),
            'end_date' => $this->getEndDate()->format(ApiClient::DATE_FORMAT),
            'time_unit' => $this->getTimeUnit()->value,
            'page' => strval($this->getPage()),
            'perpage' => strval($this->getPerPage()),
        ];
    }
}
