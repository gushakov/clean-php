<?php

namespace ExampleApp\Core\UseCase\Welcome;

use ExampleApp\Core\UseCase\ErrorHandlingPresenterOutputPort;

interface WelcomePresenterOutputPort extends ErrorHandlingPresenterOutputPort
{

    public function presentWelcomeView(bool $isUserLoggedIn, string $username): void;

}