<?php

namespace ExampleApp\Core\Port\Output\Db;

use ExampleApp\Core\Model\Greeting;
use ExampleApp\Core\Model\GreetingId;

/**
 * Output port for operations related to the persistence. It is
 * the interface to the gateway. Will be used by the use cases
 * when loading and saving models to the repository.
 */
interface PersistenceGatewayOperationsOutputPort
{

    /**
     * Loads `Greeting` from the store by its ID.
     * @throws GreetingPersistenceError if a matching `Greeting` could not be found
     */
    public function obtainGreetingById(GreetingId $greetingId): Greeting;

    /**
     * Updates an existing `Greeting` in the store.
     * @throws GreetingPersistenceError
     */
    public function updateGreeting(Greeting $updatedGreeting): void;

}