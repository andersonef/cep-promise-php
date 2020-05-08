<?php

namespace Andersonef\CepPromise;

use Andersonef\CepPromise\Exceptions\CepPromiseException;
use Andersonef\CepPromise\Interfaces\CepValidatorInterface;

class CepValidator implements CepValidatorInterface
{
    const EXPECTED_CEP_LENGTH = 8;

    protected $cep;

    public function input($cep): CepValidatorInterface
    {
        $this->cep = $cep;

        return $this;
    }

    public function validateInputType(): CepValidatorInterface
    {
        if (!is_string($this->cep)) {
            throw new CepPromiseException('CEP must be a string.');
        }

        return $this;
    }

    public function validateInputLength(): CepValidatorInterface
    {
        if (strlen($this->cep) != self::EXPECTED_CEP_LENGTH) {
            throw new CepPromiseException('Invalid cep length!');
        }

        return $this;
    }
}
