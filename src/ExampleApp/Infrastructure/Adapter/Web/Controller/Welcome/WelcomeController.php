<?php

namespace ExampleApp\Infrastructure\Adapter\Web\Controller\Welcome;

class WelcomeController
{

    private \ExampleApp\Core\Port\Input\Welcome\WelcomeInputPort $useCase;

    /**
     * @param \ExampleApp\Core\Port\Input\Welcome\WelcomeInputPort $useCase
     */
    public function __construct(\ExampleApp\Core\Port\Input\Welcome\WelcomeInputPort $useCase)
    {
        $this->useCase = $useCase;
    }


    public function __invoke(): void
    {
        $this->useCase->welcome();
    }
}