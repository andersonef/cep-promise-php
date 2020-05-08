<?php

namespace Andersonef\CepPromise\Tests;

use Andersonef\CepPromise\ResponseAddress;
use Andersonef\CepPromise\Services\WideNetService;
use PHPUnit\Framework\TestCase;

class WideNetServiceTest extends TestCase
{
    public function testWideNet()
    {
        $service = new WideNetService();
        $response = $service->fetch('83322170');

        $this->assertInstanceOf(ResponseAddress::class, $response);
        $this->assertEquals('Pinhais', $response->city);
        $this->assertEquals('PR', $response->state);
    }
}
