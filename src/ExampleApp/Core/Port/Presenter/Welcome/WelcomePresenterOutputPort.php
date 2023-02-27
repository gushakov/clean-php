<?php

namespace ExampleApp\Core\Port\Presenter\Welcome;

use ExampleApp\Core\Port\Presenter\ErrorHandlingPresenterOutputPort;

interface WelcomePresenterOutputPort extends ErrorHandlingPresenterOutputPort
{

    public function presentWelcomeView(bool $isUserLoggedIn, string $username): void;

}