<?php

namespace Andersonef\CepPromise\Tests;

use Andersonef\CepPromise\CepPromise;
use Andersonef\CepPromise\Exceptions\CepPromiseException;
use Andersonef\CepPromise\ResponseAddress;
use PHPUnit\Framework\TestCase;

final class CepPromiseTest extends TestCase
{
    public function testCanBringInformationFromValidCep()
    {
        $cep = '83322-170';
        $response = (new CepPromise($cep))->fetch()->wait();
        $this->assertInstanceOf(ResponseAddress::class, $response);
        $this->assertEquals('83322170', $response->cep);
        $this->assertEquals('PR', $response->state);
    }

    public function testItDoesLaunchTheCorrectTypeOfException()
    {
        $cep = '00000000';
        $this->expectException(CepPromiseException::class);
        $response = (new CepPromise($cep))->fetch()->wait();
    }
}
