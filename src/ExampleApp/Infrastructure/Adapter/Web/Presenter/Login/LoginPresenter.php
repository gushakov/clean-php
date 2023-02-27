<?php

namespace ExampleApp\Infrastructure\Adapter\Web\Presenter\Login;

use ExampleApp\Infrastructure\Adapter\Web\Presenter\AbstractWebPresenter;

class LoginPresenter extends AbstractWebPresenter implements \ExampleApp\Core\Port\Presenter\Login\LoginPresenterOutputPort
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