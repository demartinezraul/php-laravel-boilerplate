<?php

namespace Core\Domain\HttpClients;

interface BaseHttpClientInterface
{
    public function get(string $endpoint, array $headers = [], $body = null);

    public function post(string $endpoint, array $header = [], $body = null);

    public function put(string $endpoint, array $headers = [], $body = null);

    public function patch(string $endpoint, array $headers = [], $body = null);

    public function delete(string $endpoint, array $headers = [], $body = null);

    public function options(string $endpoint, array $headers = []);

    public function head(string $endpoint, array $headers = []);
}
