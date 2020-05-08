<?php

namespace Andersonef\CepPromise\Services;

use Andersonef\CepPromise\Interfaces\CepServiceInterface;
use Andersonef\CepPromise\ResponseAddress;
use DOMDocument;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class CorreiosService implements CepServiceInterface
{
    public function fetch($cep): ResponseAddress
    {
        $headers = [
            'Content-Type' => 'text/xml;charset=UTF-8',
            'cache-control' => 'no-cache',
        ];
        $body = '<?xml version="1.0"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cli="http://cliente.bean.master.sigep.bsb.correios.com.br/"><soapenv:Header /><soapenv:Body><cli:consultaCEP><cep>'.$cep.'</cep></cli:consultaCEP></soapenv:Body></soapenv:Envelope>';
        $client = new Client();
        $request = new Request('POST', 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente', $headers, $body);
        $response = $client->send($request);
        $response = $response->getBody()->getContents();

        $dom = new DOMDocument();
        $dom->loadXML($response);

        return new ResponseAddress(
            $cep,
            $dom->getElementsByTagName('end')[0]->nodeValue,
            $dom->getElementsByTagName('bairro')[0]->nodeValue,
            $dom->getElementsByTagName('cidade')[0]->nodeValue,
            $dom->getElementsByTagName('uf')[0]->nodeValue
        );
    }
}
