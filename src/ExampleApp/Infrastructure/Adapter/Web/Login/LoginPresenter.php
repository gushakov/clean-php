<?php

namespace ExampleApp\Infrastructure\Adapter\Web\Login;

use ExampleApp\Core\UseCase\Login\LoginPresenterOutputPort;
use ExampleApp\Infrastructure\Adapter\Web\AbstractWebPresenter;

class LoginPresenter extends AbstractWebPresenter implements LoginPresenterOutputPort
{

    public function showLoginForm(): void
    {
        $this->presentTemplatedResponse('login.html');
    }

    public function acceptLogin(): void
    {
        $this->presentTemplatedResponse('login-success.html');
    }

}