<?php

namespace ExampleApp\Infrastructure\Adapter\Security;

use ExampleApp\Core\Port\Output\Security\InvalidLoginCredentialsError;
use ExampleApp\Core\Port\Output\Security\UserNotAuthenticatedError;

class SessionBackedSecurityAdapter implements \ExampleApp\Core\Port\Output\Security\SecurityOperationsOutputPort
{

    public function __construct()
    {
    }

    /**
     * @throws \ExampleApp\Core\Port\Output\Security\UserNotAuthenticatedError
     */
    public function username(): string
    {
        if (!isset($_SESSION['username'])) {
            throw new \ExampleApp\Core\Port\Output\Security\UserNotAuthenticatedError("User not authenticated");
        }

        return $_SESSION['username'];
    }

    public function isUserLoggedIn(): bool
    {
        return isset($_SESSION['username']);
    }

    /**
     * @throws \ExampleApp\Core\Port\Output\Security\InvalidLoginCredentialsError
     */
    public function registerLogin(array $configuredCredentials, array $submittedCredentials): void
    {
        if ($configuredCredentials['username'] !== $submittedCredentials['username']
            || $configuredCredentials['password'] !== $submittedCredentials['password']) {
            throw new InvalidLoginCredentialsError("Invalid credentials submitted");
        }

        $_SESSION['username'] = $configuredCredentials['username'];
    }

    public function clearLogin(string $username)
    {
        unset($_SESSION['username']);
    }

    public function assertUserIsLoggedIn(): void
    {
        if (!$this->isUserLoggedIn()) {
            throw new \ExampleApp\Core\Port\Output\Security\UserNotAuthenticatedError("Cannot perform this action if not authenticated");
        }
    }
}