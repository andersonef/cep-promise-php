<?php

namespace Andersonef\CepPromise\Services;

use Andersonef\CepPromise\Interfaces\CepServiceInterface;
use Andersonef\CepPromise\ResponseAddress;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class ViaCepService implements CepServiceInterface
{
    public function fetch($cep): ResponseAddress
    {
        $headers = [
            'Content-Type' => 'application/json;charset=UTF-8',
            'cache-control' => 'no-cache',
        ];
        $client = new Client();
        $request = new Request('GET', 'https://viacep.com.br/ws/'.$cep.'/json/', $headers);
        $response = $client->send($request);
        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return new ResponseAddress(
            $cep,
            $response->logradouro,
            $response->bairro,
            $response->localidade,
            $response->uf
        );
    }
}
