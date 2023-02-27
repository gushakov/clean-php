<?php

namespace ExampleApp\Infrastructure\Adapter\Web\Presenter\Welcome;

use ExampleApp\Core\Port\Presenter\Welcome\WelcomePresenterOutputPort;
use ExampleApp\Infrastructure\Adapter\Web\Presenter\AbstractWebPresenter;

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