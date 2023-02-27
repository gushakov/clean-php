<?php

namespace ExampleApp\Core\Model;

/**
 * Immutable value object wrapping actual primitive which will be
 * used to look up greetings in the store.
 */
class GreetingId
{

    private readonly int $id;

    /**
     * @throws InvalidDomainObjectError
     */
    public static function of(int $id): GreetingId {
        return new GreetingId($id);
    }

    /**
     * @param int $id
     * @throws InvalidDomainObjectError
     */
    public function __construct(int $id)
    {
        if ($id <= 0) {
            throw new InvalidDomainObjectError("Greeting ID must be a positive integer.");
        }
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

}