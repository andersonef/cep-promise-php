<?php

namespace Andersonef\CepPromise;

class ResponseAddress
{
    public $cep;
    public $street;
    public $neighborhood;
    public $city;
    public $state;

    public function __construct($cep, $street, $neighborhood, $city, $state)
    {
        $this->cep = $cep;
        $this->street = $street;
        $this->neighborhood = $neighborhood;
        $this->city = $city;
        $this->state = $state;
    }

    public function __toString()
    {
        return json_encode([
            'street' => $this->street,
            'neighborhood' => $this->neighborhood,
            'cep' => $this->cep,
            'city' => $this->city,
            'state' => $this->state,
        ]);
    }
}
