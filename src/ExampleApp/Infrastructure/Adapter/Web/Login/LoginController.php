<?php

namespace ExampleApp\Infrastructure\Adapter\Web\Login;

use ExampleApp\Core\UseCase\Login\LoginUserInputPort;
use Psr\Http\Message\ServerRequestInterface;

class LoginController
{

    private LoginUserInputPort $useCase;

    /**
     * @param LoginUserInputPort $useCase
     */
    public function __construct(LoginUserInputPort $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(ServerRequestInterface $request): void
    {

        if ($request->getServerParams()['PATH_INFO'] === '/login'){
            $this->initiateLogin();
        }
        elseif ($request->getServerParams()['PATH_INFO'] === '/process-login'){
            $this->processLogin($request);
        }

    }

    private function initiateLogin(): void{
        $this->useCase->initiateLogin();
    }

    private function processLogin(ServerRequestInterface $request): void {
        $form = $request->getParsedBody();
        $this->useCase->login($form['username'], $form['password']);
    }
}