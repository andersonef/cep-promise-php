<?php

namespace Andersonef\CepPromise\Tests;

use Andersonef\CepPromise\CepPromise;
use Andersonef\CepPromise\Exceptions\CepPromiseException;
use Andersonef\CepPromise\Interfaces\CepServiceInterface;
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

    public function testShouldThrowExceptionIfThereIsNoService()
    {
        $cep = '83322-170';
        $this->expectException(CepPromiseException::class);
        $promiser = new CepPromise($cep);
        $promiser->clearServices();
        $response = $promiser->fetch()->wait();
    }

    public function testShouldAvoidFetchingInAllTheServices()
    {
        $cep = '83322-170';
        $service1 = $this->createMock(CepServiceInterface::class);
        $service2 = $this->createMock(CepServiceInterface::class);
        $response = $this->createMock(ResponseAddress::class);


        $service1->expects($this->once())->method('fetch')->willReturn($response);
        $service2->expects($this->never())->method('fetch')->willReturn($response);

        $promise = new CepPromise($cep, null, null, $service1);
        $promise->appendCepService($service2);


        $response = $promise->fetch()->wait();
    }
}
