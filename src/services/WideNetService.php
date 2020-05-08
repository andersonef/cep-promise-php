<?php

namespace Andersonef\CepPromise\Services;

use Andersonef\CepPromise\Interfaces\CepServiceInterface;
use Andersonef\CepPromise\ResponseAddress;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class WideNetService implements CepServiceInterface
{
    public function fetch($cep): ResponseAddress
    {
        $headers = [
            'Content-Type' => 'application/json;charset=UTF-8',
            'cache-control' => 'no-cache',
        ];
        $client = new Client();
        $request = new Request('GET', 'https://cep.widenet.host/busca-cep/api/cep/'.$cep.'.json', $headers);
        $response = $client->send($request);
        $response = $response->getBody()->getContents();
        $response = json_decode($response);

        return new ResponseAddress(
            $cep,
            $response->address,
            $response->district,
            $response->city,
            $response->state
        );
    }
}
