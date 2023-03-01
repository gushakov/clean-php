<?php

namespace ExampleApp\Core\Port\Presenter\SayHello;

use ExampleApp\Core\Model\Greeting;
use ExampleApp\Core\Port\Presenter\ErrorHandlingPresenterOutputPort;

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