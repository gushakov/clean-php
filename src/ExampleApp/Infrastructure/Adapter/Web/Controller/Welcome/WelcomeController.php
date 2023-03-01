<?php

namespace ExampleApp\Infrastructure\Adapter\Web\Controller\Welcome;

use ExampleApp\Core\Port\Input\Welcome\WelcomeInputPort;

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