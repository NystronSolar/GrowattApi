<?php

namespace NystronSolar\GrowattApi\Tests;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

trait Helper
{
    public function createResponseInterface(array $content): ResponseInterface
    {
        return new Response(200, [], json_encode($content));
    }
}
