<?php

namespace Core\Domain\Services;

use Core\Domain\Services\Contracts\ExampleServiceInterface;

class ExampleService implements ExampleServiceInterface
{
    private BaseRepositoryInterface $exampleRepository;
    private BaseHttpClientInterface $exampleHttpClient;

    public function __construct(
        BaseRepositoryInterface $exampleRepository,
        BaseHttpClientInterface $examplehttpClient
    ) {
        $this->exampleRepository = $exampleRepository;
        $this->examplehttpClient = $examplehttpClient;
    }

    public function doSomething()
    {
        //
    }
}
