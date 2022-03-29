<?php

namespace Core\Infrastructure\HttpClients;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Core\Domain\HttpClients\BaseHttpClientInterface;

abstract class AbstractBaseHttpClient implements BaseHttpClientInterface
{
    private ClientInterface $httpClient;
    private PromiseInterface $promise;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function get(string $endpoint, array $headers = [], $body = null)
    {
        $this->setRequestAsync('GET', $endpoint, $headers, $body);

        return $this->promise;
    }

    public function post(string $endpoint, array $headers = [], $body = null)
    {
        $this->setRequestAsync('POST', $endpoint, $headers, $body);

        return $this->promise;
    }

    public function put(string $endpoint, array $headers = [], $body = null)
    {
        $this->setRequestAsync('PUT', $endpoint, $headers, $body);

        return $this->promise;
    }

    public function patch(string $endpoint, array $headers = [], $body = null)
    {
        $this->setRequestAsync('PATCH', $endpoint, $headers, $body);

        return $this->promise;
    }

    public function delete(string $endpoint, array $headers = [], $body = null)
    {
        $this->setRequestAsync('DELETE', $endpoint, $headers, $body);

        return $this->promise;
    }

    public function options(string $endpoint, array $headers = [])
    {
        $this->setRequestAsync('OPTIONS', $endpoint, $headers, null);

        return $this->promise;
    }

    public function head(string $endpoint, array $headers = [])
    {
        $this->setRequestAsync('HEAD', $endpoint, $headers, null);

        return $this->promise;
    }

    protected function setBaseURI(string $baseUri): void
    {
        $this->baseUri = $baseUri . '/';
    }

    private function setRequestAsync(string $method, string $endpoint, array $headers, $body)
    {
        $request = new Request($method, $this->baseUri . $endpoint, $headers, $body);
        $this->promise = $this->httpClient->sendAsync($request)->then(function ($response) {
            return $response->getBody()->getContents();
        });
        $this->promise->then(
            function (ResponseInterface $res) {
                return $res->getBody();
            },
            function (RequestException $e) {
                return $e->getMessage();
            }
        );
    }
}
