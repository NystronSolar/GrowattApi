<?php

namespace NystronSolar\GrowattApiTests\Response;

use NystronSolar\GrowattApi\Entity\Plant;
use NystronSolar\GrowattApi\PHPUnit\GrowattApiTestData;
use NystronSolar\GrowattApi\Response\ApiUserPlantsResponse;
use NystronSolar\GrowattApi\Route\ApiUserPlantsRoute;
use PHPUnit\Framework\TestCase;

class ApiUserPlantsResponseTest extends TestCase
{
    use GrowattApiTestData;

    public function testRequest()
    {
        $route = new ApiUserPlantsRoute('');
        /** @var ApiUserPlantsResponse|false $response */
        $this->assertNotFalse($response = $this->makeApiClientRequest($route));
        $this->assertSame('', $response->getErrorMessage());
        $this->assertSame(0, $response->getErrorCode());
        $this->assertFalse($response->hasErrors());

        $plants = $response->getPlants();

        $this->assertCount(2, $plants);
        $this->assertEquals(new Plant('500', 1, 'Brazil', 'City', null, '', '0.0', 'en-US', 10.0, 'abc', '', 1, 'Growatt User One Plant', '2023-01-01', 0, ''), $plants[0]);
    }
}
