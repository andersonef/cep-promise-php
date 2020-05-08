<p align="center">
  <img src="http://piskel-imgstore-b.appspot.com/img/d580e96e-bd8a-11e6-b157-9949cad4d609.gif">
</p>

<h1 align="center">CEP Promise</h1>
Busca por CEP integrado diretamente aos serviços dos Correios, ViaCEP e WideNet.

## Descrição

Essa biblioteca é uma cópia da original feita pelo <a href="https://github.com/filipedeschamps" target="_blank">Filipe Deschamps (Michel Teló)</a> que achei a premissa bastante interessante e decidi copiá-la em PHP e Python.

O estilo do código é outro, visto que o Filipe usa JS com uma aobrdagem mais funcional, e eu nesse projeto optei por utilizar orientação a objetos guiada por testes.

## Features

 * Sempre atualizado em tempo-real por se conectar diretamente aos serviços dos Correios, ViaCEP e WideNet.
 * Possui alta disponibilidade por usar vários serviços como fallback.
 * Sem limites de uso (rate limits) conhecidos.
 * 100% de code coverage com testes unitários e integração.

## Como Utilizar

### Instalação

Instale via composer diretamente no bash com o comando:

```bash
composer require andersonef/cep-promise-php
```

Ou modifique seu arquivo **composer.json** acrescentando a biblioteca nas dependências:

```json
    "require": {
        "andersonef/cep-promise-php": "^1.0.0"
    }
```

### Utilização

A utilização é bem simples:

```php
$endereco = (new CepPromise('83322170'))->fetch(); 

/** Endereço: 
 * {
  "cep": "83322170",
  "street": "Rua Rio Tocantins",
  "neighborhood": "Weissópolis",
  "city": "Pinhais",
  "state": "PR"
}
*/
```

O retorno será sempre um objeto do tipo **Andersonef\CepPromise\ResponseAddress**.

### Customizando

Você pode criar novos serviços para fallback facilmente com essa biblioteca. 

Um serviço é qualquer classe que implemente a interface **Andersonef\CepPromise\Interfaces\ServiceInterface**, logo:

```php
class CepFromDatabase implements ServiceInterface
{
    public function fetch($cep): ResponseAddress
    {
        // .. your custom logic here
        $response = new ResponseAddress(
            $cep,
            $rua,
            $bairro,
            $cidade,
            $estado
        );
        return $response;
    }
}
```

Após criar seu service customizado, basta adicioná-lo à sua instância CepPromise, assim:

```php

$cepFromDatabaseService = new CepFromDatabase();
$cepPromise = new CepPromise();

$endereco = $cepPromise
    ->clearServices() // OPCIONAL: elimina os services padrão (correios, viacep e widenet)
    ->appendService($cepFromDatabaseService)
    ->fetch('83322170'); // Agora a classe irá usar seu service customizado!
```

## Tratando falhas

Qualquer erro nessa biblioteca irá disparar uma exception do tipo **Andersonef\CepPromise\CepPromiseException**.

## Deixe suas sugestões

Fique a vontade para deixar sugestões nas issues!

## Fonte

Esse pacote foi inspirado no original <a href="https://github.com/filipedeschamps/cep-promise">https://github.com/filipedeschamps/cep-promise</a>