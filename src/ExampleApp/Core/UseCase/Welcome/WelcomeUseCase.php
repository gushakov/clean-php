<?php

namespace ExampleApp\Core\UseCase\Welcome;

use ExampleApp\Core\Port\Security\SecurityOperationsOutputPort;
use ExampleApp\Core\Port\Security\UserNotAuthenticatedError;

class WelcomeUseCase implements WelcomeInputPort
{
    private WelcomePresenterOutputPort $presenter;

    private SecurityOperationsOutputPort $securityOps;

    /**
     * @param WelcomePresenterOutputPort $presenter
     * @param SecurityOperationsOutputPort $securityOps
     */
    public function __construct(WelcomePresenterOutputPort $presenter, SecurityOperationsOutputPort $securityOps)
    {
        $this->presenter = $presenter;
        $this->securityOps = $securityOps;
    }

    public function welcome(): void
    {
        // see if the user is logged in and get her username

        $username = 'undefined';
        try {
            $isUserLoggedIn = $this->securityOps->isUserLoggedIn();
            if ($isUserLoggedIn) {
                $username = $this->securityOps->username();
            }
        } catch (UserNotAuthenticatedError $e) {
            $this->presenter->presentError($e);
            return;
        }

        $this->presenter->presentWelcomeView($isUserLoggedIn, $username);
    }
}