<?php

namespace ExampleApp\Core\Port\Output\Security;

interface SecurityOperationsOutputPort
{

    /**
     * @throws UserNotAuthenticatedError
     */
    public function username(): string;

    public function isUserLoggedIn(): bool;

    /**
     * @param array $configuredCredentials
     * @param array $submittedCredentials
     * @return void
     * @throws InvalidLoginCredentialsError
     */
    public function registerLogin(array $configuredCredentials, array $submittedCredentials): void;

    public function clearLogin(string $username);

    /**
     * @return void
     * @throws UserNotAuthenticatedError
     */
    public function assertUserIsLoggedIn(): void;

}