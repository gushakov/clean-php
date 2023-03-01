<?php

namespace ExampleApp\Infrastructure\Adapter\Db;

use ExampleApp\Core\Model\Greeting;
use ExampleApp\Core\Model\GreetingId;
use ExampleApp\Core\Model\InvalidDomainObjectError;
use ExampleApp\Core\Port\Output\Db\GreetingPersistenceError;
use ExampleApp\Core\Port\Output\Db\PersistenceGatewayOperationsOutputPort;
use SleekDB\Exceptions\InvalidArgumentException;
use SleekDB\Exceptions\IOException;
use SleekDB\Exceptions\JsonException;
use SleekDB\Store;

/**
 * Secondary adapter (or gateway) for persisting model entities
 * in a file base store (in JSON format). Uses SleekDB store for
 * implementation. Gateway will look up persistent entities from
 * the database and map them to corresponding model entities. This
 * following closely the REPOSITORY pattern from DDD.
 * Gateway should translate any low-level technical exceptions to
 * the business exceptions, which will be propagated to the use case.
 * @see PersistenceMapper
 * @see GreetingPersistenceError
 */
class FilePersistenceGateway implements PersistenceGatewayOperationsOutputPort
{

    private Store $store;
    private PersistenceMapper $mapper;

    /**
     * @param Store $store
     * @param PersistenceMapper $mapper
     */
    public function __construct(Store $store, PersistenceMapper $mapper)
    {
        $this->store = $store;
        $this->mapper = $mapper;
    }

    /**
     * @throws GreetingPersistenceError
     */
    public function obtainGreetingById(GreetingId $greetingId): Greeting
    {
        $id = $greetingId->getId();
        try {
            $dto = $this->store->findById($id);
        } catch (InvalidArgumentException $e) {
            throw new GreetingPersistenceError("Invalid ID for DB operation. {$e->getMessage()}");
        }
        if ($dto == null) {
            throw new GreetingPersistenceError("Could not find Greeting with ID: $id in the database");
        }
        try {
            return $this->mapper->convertFromArrayToGreeting($dto);
        } catch (InvalidDomainObjectError $e) {
            throw new GreetingPersistenceError("Cannot map greeting with ID $id from DB entity. {$e->getMessage()}");
        }
    }

    /**
     * @throws GreetingPersistenceError
     */
    public function updateGreeting(Greeting $updatedGreeting): void
    {
        try {
            $dbGreeting = $this->mapper->convertFromGreetingToArray($updatedGreeting);
            $this->store->updateById($updatedGreeting->getGreetingId()->getId(), $dbGreeting);
        } catch (IOException|InvalidArgumentException|JsonException $e) {
            throw new GreetingPersistenceError("Could not update greeting with ID: " .
                $updatedGreeting->getGreetingId()->getId() .
                " {$e->getMessage()}");
        }
    }
}