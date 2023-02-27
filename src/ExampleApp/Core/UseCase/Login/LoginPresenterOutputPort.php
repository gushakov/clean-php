<?php

namespace ExampleApp\Core\UseCase\Login;

use ExampleApp\Core\UseCase\ErrorHandlingPresenterOutputPort;

interface LoginPresenterOutputPort extends ErrorHandlingPresenterOutputPort
{

    public function showLoginForm(): void;

    public function acceptLogin(): void;


}