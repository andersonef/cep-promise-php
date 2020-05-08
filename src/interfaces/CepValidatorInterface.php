<?php

namespace Andersonef\CepPromise\Interfaces;

interface CepValidatorInterface
{
    public function input($cep): CepValidatorInterface;

    public function validateInputType(): CepValidatorInterface;

    public function validateInputLength(): CepValidatorInterface;
}
