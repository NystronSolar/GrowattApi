<?php

namespace NystronSolar\GrowattApiTests\Client;

use NystronSolar\GrowattApi\Client\FakeApiClient;
use NystronSolar\GrowattApi\Entity\Plant;
use NystronSolar\GrowattApi\Entity\TimeUnit;
use NystronSolar\GrowattApi\Entity\User;
use PHPUnit\Framework\TestCase;

class FakeApiClientTest extends TestCase
{
    public function testGetAllUsersRequest()
    {
        $fakeApiClient = new FakeApiClient();

        $this->assertNotFalse($response = $fakeApiClient->getAllUsersRequest());
        $this->assertSame('', $response->getErrorMessage());
        $this->assertSame(0, $response->getErrorCode());
        $this->assertFalse($response->hasErrors());

        $users = $response->getUsers();

        $this->assertCount(4, $users);
        $this->assertEquals(new User(1, 'Tim Goland', 'tim@email.com', '0123456789', '2023-01-01 01:01:01'), $users[0]);
        $this->assertEquals(new User(2, 'Leo de Carpi', 'carpi@email.com', '0123456789', '2023-01-01 01:01:01'), $users[1]);
        $this->assertEquals(new User(3, 'Max Verstop', 'max@email.com', '0123456789', '2023-01-01 01:01:01'), $users[2]);
        $this->assertEquals(new User(4, 'Folipe Drugo', 'drugo@email.com', '0123456789', '2023-01-01 01:01:01'), $users[3]);
    }

    public function testCheckUserExistsRequestWithNonexistentUser()
    {
        $fakeApiClient = new FakeApiClient();

        $this->assertNotFalse($response = $fakeApiClient->checkUserExistsRequest('Nonexistent User'));
        $this->assertSame('', $response->getErrorMessage());
        $this->assertSame(0, $response->getErrorCode());
        $this->assertFalse($response->hasErrors());

        $this->assertFalse($response->userExists());
    }

    public function testCheckUserExistsRequestWithExistentUser()
    {
        $fakeApiClient = new FakeApiClient();

        $this->assertNotFalse($response = $fakeApiClient->checkUserExistsRequest('Tim Goland'));
        $this->assertSame('', $response->getErrorMessage());
        $this->assertSame(0, $response->getErrorCode());
        $this->assertFalse($response->hasErrors());

        $this->assertTrue($response->userExists());
    }

    public function testGetPlantHistoryRequestWithNonexistentPlant()
    {
        $fakeApiClient = new FakeApiClient();

        $this->assertNotFalse($response = $fakeApiClient->getPlantHistoryRequest(123, TimeUnit::Day, new \DateTimeImmutable('2023-01-01')));
        $this->assertSame('error_Plant does not exist', $response->getErrorMessage());
        $this->assertSame(10002, $response->getErrorCode());
        $this->assertTrue($response->hasErrors());
        $this->assertEmpty($response->getEnergies());
        $this->assertSame(TimeUnit::Day, $response->getTimeUnit());
    }

    public function testGetPlantHistoryRequestWithExistentPlant()
    {
        $fakeApiClient = new FakeApiClient();

        $this->assertNotFalse($response = $fakeApiClient->getPlantHistoryRequest(1, TimeUnit::Day, new \DateTimeImmutable('2023-01-01')));
        $this->assertSame('', $response->getErrorMessage());
        $this->assertSame(0, $response->getErrorCode());
        $this->assertFalse($response->hasErrors());

        $this->assertCount(7, $energies = $response->getEnergies());
        $this->assertSame('2023-01-01', $energies[0]->getDate()->format('2023-01-01'));
        $this->assertMatchesRegularExpression("/(([0-9]{1})|([0-9]{2}))\.[0-9]/", $energies[0]->getGeneration());
    }

    public function testGetUserPlantsRequestWithNonexistentUser()
    {
        $fakeApiClient = new FakeApiClient();

        $this->assertNotFalse($response = $fakeApiClient->getUserPlantsRequest('Nonexistent User'));
        $this->assertSame('error_permission_denied', $response->getErrorMessage());
        $this->assertSame(10011, $response->getErrorCode());
        $this->assertTrue($response->hasErrors());
        $this->assertEmpty($response->getPlants());
    }

    public function testGetUserPlantsRequestWithExistentUser()
    {
        $fakeApiClient = new FakeApiClient();

        $this->assertNotFalse($response = $fakeApiClient->getUserPlantsRequest('Tim Goland'));
        $this->assertSame('', $response->getErrorMessage());
        $this->assertSame(0, $response->getErrorCode());
        $this->assertFalse($response->hasErrors());

        $this->assertNotNull($plant = $response->getPlants()[0]);
        $this->assertEquals(new Plant('10000', 1, 'Brazil', 'Pelotas', null, '-10.123456', '300.5', 'en-US', '10.3', '0', '0', 1, 'Tim Goland Plant', '2023-01-01', 1, '-50.123456'), $plant);
    }
}
