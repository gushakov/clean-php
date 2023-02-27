<?php

namespace ExampleApp\Core\Port\Presenter\Login;

use ExampleApp\Core\Port\Presenter\ErrorHandlingPresenterOutputPort;

interface LoginPresenterOutputPort extends ErrorHandlingPresenterOutputPort
{

    public function showLoginForm(): void;

    public function acceptLogin(): void;


}