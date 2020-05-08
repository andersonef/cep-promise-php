<?php

namespace Andersonef\CepPromise\Interfaces;

use Andersonef\CepPromise\ResponseAddress;

interface CepServiceInterface
{
    public function fetch($cep): ResponseAddress;
}
