<?php
namespace Andersonef\CepPromise\Tests;

use Andersonef\CepPromise\CepSanitizer;
use PHPUnit\Framework\TestCase;

class CepSanitizerTest extends TestCase
{

    public function testItDoesRemoveNotNumericChars()
    {
        $sanitizer = new CepSanitizer();
        $invalidCep = 'Cep: 83322-170';
        $expectedCEp = '83322170';
        $obtainedCep = $sanitizer
            ->input($invalidCep)
            ->removeSpecialCharacters()
            ->getSanitizedCep();
        
        $this->assertEquals($expectedCEp, $obtainedCep);
    }

    public function testItDoesPaddingWithZeros()
    {
        $sanitizer = new CepSanitizer();
        $invalidCep = '322170';
        $expectedCEp = '00322170';
        $obtainedCep = $sanitizer
            ->input($invalidCep)
            ->leftPadWithZeros()
            ->getSanitizedCep();
        
        $this->assertEquals($expectedCEp, $obtainedCep);
    }
}