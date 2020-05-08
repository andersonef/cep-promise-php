<?php

namespace Andersonef\CepPromise\Interfaces;

interface CepSanitizerInterface
{
    public function input($cep): CepSanitizerInterface;

    public function removeSpecialCharacters(): CepSanitizerInterface;

    public function leftPadWithZeros(): CepSanitizerInterface;

    public function getSanitizedCep();
}
