<?php

namespace NystronSolar\GrowattApiTests\PHPUnit;

use GuzzleHttp\Client;

trait Stubs
{
    use Helper;

    /**
     * @param class-string $class
     */
    protected function createStubFor(string $class, string $method, mixed $return): \PHPUnit\Framework\MockObject\Stub
    {
        $stub = $this->createStub($class);

        $stub->method($method)
            ->willReturn($return)
        ;

        return $stub;
    }

    protected function createStubForGuzzleClient(string $method, array $body): \PHPUnit\Framework\MockObject\Stub|Client
    {
        return $this->createStubFor(Client::class, $method, $this->createResponseInterface($body));
    }
}
