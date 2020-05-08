<?php
namespace Andersonef\CepPromise\Tests;

use Andersonef\CepPromise\CepValidator;
use Andersonef\CepPromise\Exceptions\CepPromiseException;
use PHPUnit\Framework\TestCase;

class CepValidatorTest extends TestCase
{
    public function testItDoesNotValidForNonStringTypes()
    {
        $validator = new CepValidator();

        $invalidInputCep = new \DateTime();
        $this->expectException(CepPromiseException::class);
        $validator
            ->input($invalidInputCep)
            ->validateInputType();
    }

    public function testItDoesValidForStringTypes()
    {
        $validator = new CepValidator();

        $invalidInputCep = '65446545456464';
        $validator
            ->input($invalidInputCep)
            ->validateInputType();
        $this->assertTrue(true);
    }
}