<?php

namespace Andersonef\CepPromise\Tests;

use Andersonef\CepPromise\ResponseAddress;
use Andersonef\CepPromise\Services\CorreiosService;
use PHPUnit\Framework\TestCase;

class CorreiosServiceTest extends TestCase
{
    public function testCorreios()
    {
        $service = new CorreiosService();
        $response = $service->fetch('83322170');

        $this->assertInstanceOf(ResponseAddress::class, $response);
        $this->assertEquals('Pinhais', $response->city);
        $this->assertEquals('PR', $response->state);
    }
}
