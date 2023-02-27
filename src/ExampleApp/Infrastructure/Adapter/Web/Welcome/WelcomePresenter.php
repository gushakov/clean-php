<?php

namespace ExampleApp\Infrastructure\Adapter\Web\Welcome;

use ExampleApp\Core\UseCase\Welcome\WelcomePresenterOutputPort;
use ExampleApp\Infrastructure\Adapter\Web\AbstractWebPresenter;

class WelcomePresenter extends AbstractWebPresenter implements WelcomePresenterOutputPort
{

    public function presentWelcomeView(bool $isUserLoggedIn, string $username): void
    {

        $this->presentTemplatedResponse('welcome.html', [
            'userLoggedIn' => $isUserLoggedIn,
            'username' => $username
        ]);
    }
}