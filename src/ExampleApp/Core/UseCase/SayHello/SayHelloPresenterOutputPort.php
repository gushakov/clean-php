<?php

namespace ExampleApp\Core\UseCase\SayHello;

use ExampleApp\Core\Model\Greeting;
use ExampleApp\Core\UseCase\ErrorHandlingPresenterOutputPort;

/**
 * Interface for the presenter. It is an output port through which
 * a use case will communicate back to the caller. All Presenters
 * should provide a way to present errors.
 * @see ErrorHandlingPresenterOutputPort
 */
interface SayHelloPresenterOutputPort extends ErrorHandlingPresenterOutputPort
{
    public function presentGreetingToUser(Greeting $greeting): void;
}