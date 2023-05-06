<?php

namespace NystronSolar\GrowattApiTests\Response;

use NystronSolar\GrowattApi\Entity\Energy;
use NystronSolar\GrowattApi\Entity\TimeUnit;
use NystronSolar\GrowattApi\PHPUnit\GrowattApiTestData;
use NystronSolar\GrowattApi\Response\ApiPlantHistoryResponse;
use NystronSolar\GrowattApi\Route\ApiPlantHistoryRoute;
use PHPUnit\Framework\TestCase;

class ApiPlantHistoryResponseTest extends TestCase
{
    use GrowattApiTestData;

    public function testRequest()
    {
        $route = new ApiPlantHistoryRoute(1, TimeUnit::Day, new \DateTimeImmutable('2023-01-01'));
        /** @var ApiPlantHistoryResponse|false $response */
        $this->assertNotFalse($response = $this->makeApiClientRequest($route));
        $this->assertSame('', $response->getErrorMessage());
        $this->assertSame(0, $response->getErrorCode());
        $this->assertFalse($response->hasErrors());

        $energies = $response->getEnergies();

        $this->assertCount(2, $energies);
        $this->assertEquals(new Energy('2023-01-01', '100'), $energies[0]);
    }
}
