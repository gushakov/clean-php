<?php

namespace ExampleApp\Core\UseCase\UpdateAuthor;

use ExampleApp\Core\Model\GreetingId;
use ExampleApp\Core\Model\InvalidDomainObjectError;
use ExampleApp\Core\Port\Input\UpdateAuthor\UpdateAuthorInputPort;
use ExampleApp\Core\Port\Output\Db\GreetingPersistenceError;
use ExampleApp\Core\Port\Output\Db\PersistenceGatewayOperationsOutputPort;
use ExampleApp\Core\Port\Output\Security\SecurityOperationsOutputPort;
use ExampleApp\Core\Port\Output\Security\UserNotAuthenticatedError;
use ExampleApp\Core\Port\Presenter\UpdateAuthor\UpdateAuthorPresenterOutputPort;
use TypeError;

class UpdateAuthorUseCase implements UpdateAuthorInputPort
{

    private UpdateAuthorPresenterOutputPort $presenter;

    private SecurityOperationsOutputPort $securityOps;
    private PersistenceGatewayOperationsOutputPort $gatewayOps;

    /**
     * @param UpdateAuthorPresenterOutputPort $presenter
     * @param \ExampleApp\Core\Port\Output\Security\SecurityOperationsOutputPort $securityOps
     * @param PersistenceGatewayOperationsOutputPort $gatewayOps
     */
    public function __construct(UpdateAuthorPresenterOutputPort        $presenter,
                                SecurityOperationsOutputPort           $securityOps,
                                PersistenceGatewayOperationsOutputPort $gatewayOps)
    {
        $this->presenter = $presenter;
        $this->gatewayOps = $gatewayOps;
        $this->securityOps = $securityOps;
    }

    public function editAuthorOfGreeting()
    {
        $this->presenter->presentEditAuthorOfGreetingView();
    }

    /*
     * Validating types of inputs to the use case follow the same
     * logic as any other operation in the use case: when instantiating
     * value objects or calling an output ports, for example. See
     * "TypeError" exception in the "try-catch" below.
     */

    public function updateAuthorOfGreeting(string|int $greetingId, string $updatedAuthorName): void
    {

        try {

            /*
             * Security checks are done in the use cases. Here
             * we assert that the current user is authenticated
             * before actually updating a greeting.
             */
            $this->securityOps->assertUserIsLoggedIn();

            // construct GreetingID value object
            $greetingId = GreetingId::of($greetingId);
            // find the greeting
            $greeting = $this->gatewayOps->obtainGreetingById($greetingId);
            // make new (updated) greeting
            $updatedGreeting = $greeting->withAuthorName($updatedAuthorName);
            // persist updated greeting
            $this->gatewayOps->updateGreeting($updatedGreeting);
        } catch (UserNotAuthenticatedError|TypeError|InvalidDomainObjectError|GreetingPersistenceError $e) {
            $this->presenter->presentError($e);
            return;
        }

        $this->presenter->presentAuthorUpdatedSuccessfully($greetingId);
    }
}