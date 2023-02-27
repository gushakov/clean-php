<?php

namespace ExampleApp\Infrastructure\Application;

use Narrowspark\HttpEmitter\SapiEmitter;
use Psr\Http\Message\ResponseInterface;

class SapiResponseEmitter implements ResponseEmitter
{

    private SapiEmitter $sapiEmitter;

    public function __construct()
    {
        $this->sapiEmitter = new SapiEmitter();
    }

    public function emit(ResponseInterface $response): void
    {
        $this->sapiEmitter->emit($response);
    }

}