<?php

namespace Andersonef\CepPromise\Tests;

use Andersonef\CepPromise\ResponseAddress;
use Andersonef\CepPromise\Services\ViaCepService;
use PHPUnit\Framework\TestCase;

class ViaCepServiceTest extends TestCase
{
    public function testViaCep()
    {
        $service = new ViaCepService();
        $response = $service->fetch('83322170');

        $this->assertInstanceOf(ResponseAddress::class, $response);
        $this->assertEquals('Pinhais', $response->city);
        $this->assertEquals('PR', $response->state);
    }
}
