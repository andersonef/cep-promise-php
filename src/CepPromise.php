<?php

namespace Andersonef\CepPromise;

use Andersonef\CepPromise\Exceptions\CepPromiseException;
use Andersonef\CepPromise\Interfaces\CepSanitizerInterface;
use Andersonef\CepPromise\Interfaces\CepServiceInterface;
use Andersonef\CepPromise\Interfaces\CepValidatorInterface;
use Andersonef\CepPromise\Services\CorreiosService;
use Andersonef\CepPromise\Services\ViaCepService;
use Andersonef\CepPromise\Services\WideNetService;
use GuzzleHttp\Promise\Promise;
use function GuzzleHttp\Promise\any;

class CepPromise
{
    protected $rawCep;

    protected $finalCep;

    protected $cepSanitizer;

    protected $cepValidator;

    protected $cepServices;

    public function __construct(
        $rawCep,
        CepSanitizerInterface $cepSanitizer = null,
        CepValidatorInterface $cepValidator = null,
        CepServiceInterface ...$cepServices
    ) {
        $this->rawCep = $rawCep;
        $this->cepSanitizer = $cepSanitizer ?? new CepSanitizer();
        $this->cepValidator = $cepValidator ?? new CepValidator();
        $this->cepServices = (count($cepServices) > 0) ? $cepServices : [
            new CorreiosService(),
           // new ViaCepService(),
         //   new WideNetService(),
        ];
    }

    public function appendCepService(CepServiceInterface $cepService): CepPromise
    {
        $this->cepServices[] = $cepService;

        return $this;
    }

    public function clearServices(): CepPromise
    {
        $this->cepServices = [];

        return $this;
    }

    public function fetch(): Promise
    {
        if (count($this->cepServices) == 0) {
            throw new CepPromiseException('Empty service list.');
        }
        $this->finalCep = $this
            ->cepSanitizer
            ->input($this->rawCep)
            ->removeSpecialCharacters()
            ->leftPadWithZeros()
            ->getSanitizedCep();

        $this->cepValidator
            ->input($this->finalCep)
            ->validateInputLength()
            ->validateInputType();

        $promises = [];
        $promise = null;
        foreach ($this->cepServices as $i => $service) {
            $promises[$i] = new Promise(function () use (&$promises, $service, $i) {
                try {
                    $response = $service->fetch($this->finalCep);
                    $promises[$i]->resolve($response);
                } catch (\Exception $e) {
                    $promises[$i]->reject($e->getMessage());

                    return;
                }
            });
        }

        return any($promises)
            ->then(function ($response) {
                return $response;
            }, function ($error) {
                throw new CepPromiseException('Couldn\'t fetch from any service!'.$error->getMessage());
            });
    }
}
