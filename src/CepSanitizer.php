<?php

namespace Andersonef\CepPromise;

use Andersonef\CepPromise\Exceptions\CepPromiseException;
use Andersonef\CepPromise\Interfaces\CepSanitizerInterface;

class CepSanitizer implements CepSanitizerInterface
{
    const CEP_EXPECTED_LENGTH = 8;

    protected $cep;

    protected $removedSpecialChars = false;

    protected $leftPaddedWithZeros = false;

    public function input($cep): CepSanitizerInterface
    {
        $this->cep = $cep;

        return $this;
    }

    public function removeSpecialCharacters(): CepSanitizerInterface
    {
        try {
            $this->cep = preg_replace('/([^0-9])/', '', $this->cep);
        } catch (\Exception $e) {
            throw new CepPromiseException('Couldn\'t remove special chars from cep "'.$this->cep.'"', 0, $e);
        }

        $this->removedSpecialChars = true;

        return $this;
    }

    public function leftPadWithZeros(): CepSanitizerInterface
    {
        try {
            $this->cep = str_pad($this->cep, self::CEP_EXPECTED_LENGTH, '0', STR_PAD_LEFT);
        } catch (\Exception $e) {
            throw new CepPromiseException('Couldn\'t pad cep "'.$this->cep.'" with zeros', 0, $e);
        }
        $this->leftPaddedWithZeros = true;

        return $this;
    }

    public function getSanitizedCep()
    {
        if (!$this->removedSpecialChars) {
            $this->removeSpecialCharacters();
        }
        if (!$this->leftPaddedWithZeros) {
            $this->leftPadWithZeros();
        }

        return $this->cep;
    }
}
