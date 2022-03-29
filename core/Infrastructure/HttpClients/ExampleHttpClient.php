<?php

namespace Core\Infrastructure\HttpClients;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Core\Domain\HttpClients\ExampleHttpClientInterface;

/**
* Este componente é utilizado para enviar solicitações HTTP para algum serviço ou endpoint.
*
* É comumente utilizado para realizar integrações com outros sistemas.
*
* Referências:
* @see https://martinfowler.com/eaaCatalog/repository.html
* @see https://docs.microsoft.com/en-us/previous-versions/msp-n-p/ff649690(v=pandp.10)?redirectedfrom=MSDN
**/
class ExampleHttpClient extens AbstractHttpCliente implements ExampleHttpClientInterface
{

    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient);
        $this->setBaseURI(env('EXAMPLE_API_BASE_URI'));
    }

    public function getEndpoint()
    {
        return json_decode($this->get('todos')->wait(), true);
    }

    public function postEndpoint()
    {
        return json_decode($this->get('todos')->wait(), true);
    }
}
