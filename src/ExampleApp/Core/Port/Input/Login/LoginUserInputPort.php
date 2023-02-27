<?php

namespace ExampleApp\Core\Port\Input\Login;

interface LoginUserInputPort
{
    public function initiateLogin(): void;

    public function login(string $submittedUsername, string $submittedPassword): void;
}