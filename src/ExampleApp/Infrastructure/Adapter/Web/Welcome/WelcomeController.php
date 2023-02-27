<?php

namespace ExampleApp\Infrastructure\Adapter\Web\Welcome;

use ExampleApp\Core\UseCase\Welcome\WelcomeInputPort;

class WelcomeController
{

    private WelcomeInputPort $useCase;

    /**
     * @param WelcomeInputPort $useCase
     */
    public function __construct(WelcomeInputPort $useCase)
    {
        $this->useCase = $useCase;
    }


    public function __invoke(): void
    {
        $this->useCase->welcome();
    }
}