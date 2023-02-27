<?php
declare(strict_types=1);

namespace ExampleApp\Core\UseCase\SayHello;

use ExampleApp\Core\Model\GreetingId;
use ExampleApp\Core\Model\InvalidDomainObjectError;
use ExampleApp\Core\Port\Db\GreetingPersistenceError;
use ExampleApp\Core\Port\Db\PersistenceGatewayOperationsOutputPort;

/**
 * One of the most important concepts in Clean Architecture: a Use Case.
 * Also called "an Interactor" (Robert C. Martin). It describes a
 * specific business scenario. It is usually specific to a particular
 * user of the application. Each use case must implement an Input Port.
 */
class SayHelloUseCase implements SayHelloInputPort
{

    /*
     * Each use case will receive a Presenter and a number
     * of Output Ports.
     */

    private SayHelloPresenterOutputPort $presenter;
    private PersistenceGatewayOperationsOutputPort $gatewayOps;

    public function __construct(SayHelloPresenterOutputPort $presenter, PersistenceGatewayOperationsOutputPort $gatewayOps)
    {
        $this->presenter = $presenter;
        $this->gatewayOps = $gatewayOps;
    }

    public function greetUser(): void
    {
        /*
         * Each use case will perform some (small) amount of business logic
         * necessary to implement the scenario. This will usually involve
         * one or several calls to any output ports (retrieving or persisting
         * entities from or to the gateway, for example). Any security checks,
         * such as permission of the current user to perform any action with
         * any of the models, will be done at this point in the use case.
         * Use case will usually call the Presenter either requesting a successful
         * presentation of the results of the business process or requesting
         * to present any errors.
         */

        $id = rand(1, 5);
        try {
            $greeting = $this->gatewayOps->obtainGreetingById(GreetingId::of($id));
        } catch (InvalidDomainObjectError|GreetingPersistenceError $e) {
            $this->presenter->presentError($e);
            return;
        }

        $this->presenter->presentGreetingToUser($greeting);
    }
}
