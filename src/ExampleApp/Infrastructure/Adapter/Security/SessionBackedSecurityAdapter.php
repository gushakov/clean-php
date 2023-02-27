<?php

namespace ExampleApp\Infrastructure\Adapter\Security;

use ExampleApp\Core\Port\Security\InvalidLoginCredentialsError;
use ExampleApp\Core\Port\Security\SecurityOperationsOutputPort;
use ExampleApp\Core\Port\Security\UserNotAuthenticatedError;

class SessionBackedSecurityAdapter implements SecurityOperationsOutputPort
{

    public function __construct()
    {
    }

    /**
     * @throws UserNotAuthenticatedError
     */
    public function username(): string
    {
        if (!isset($_SESSION['username'])) {
            throw new UserNotAuthenticatedError("User not authenticated");
        }

        return $_SESSION['username'];
    }

    public function isUserLoggedIn(): bool
    {
        return isset($_SESSION['username']);
    }

    /**
     * @throws InvalidLoginCredentialsError
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
            throw new UserNotAuthenticatedError("Cannot perform this action if not authenticated");
        }
    }
}