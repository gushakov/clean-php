<?php

namespace ExampleApp\Core\UseCase\Login;

interface LoginUserInputPort
{
    public function initiateLogin(): void;

    public function login(string $submittedUsername, string $submittedPassword): void;
}