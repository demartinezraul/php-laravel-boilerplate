<?php

namespace Core\Domain\HttpClients;

interface ExampleHttpClientInterface
{
    public function getEndpoint();
    public function postEndpoint();
}
