<?php

namespace ExampleApp\Core\UseCase\Login;

use ExampleApp\Core\Port\Input\Login\LoginUserInputPort;
use ExampleApp\Core\Port\Output\Config\ConfigOperationsOutputPort;
use ExampleApp\Core\Port\Output\Security\InvalidLoginCredentialsError;
use ExampleApp\Core\Port\Output\Security\SecurityOperationsOutputPort;
use ExampleApp\Core\Port\Presenter\Login\LoginPresenterOutputPort;

class LoginUserUseCase implements LoginUserInputPort
{
    private LoginPresenterOutputPort $presenter;

    private ConfigOperationsOutputPort $configOps;

    private SecurityOperationsOutputPort $securityOps;

    /**
     * @param LoginPresenterOutputPort $presenter
     * @param ConfigOperationsOutputPort $configOps
     * @param \ExampleApp\Core\Port\Output\Security\SecurityOperationsOutputPort $securityOps
     */
    public function __construct(LoginPresenterOutputPort     $presenter,
                                ConfigOperationsOutputPort   $configOps,
                                SecurityOperationsOutputPort $securityOps)
    {
        $this->presenter = $presenter;
        $this->configOps = $configOps;
        $this->securityOps = $securityOps;
    }

    public function initiateLogin(): void
    {

        $this->presenter->showLoginForm();
    }


    public function login(string $submittedUsername, string $submittedPassword): void
    {
        try {
            $this->securityOps->registerLogin([
                'username' => $this->configOps->username(),
                'password' => $this->configOps->password()
            ],
                [
                    'username' => $submittedUsername,
                    'password' => $submittedPassword
                ]);
        } catch (InvalidLoginCredentialsError $e) {
            $this->presenter->presentError($e);
            return;
        }

        $this->presenter->acceptLogin();
    }
}