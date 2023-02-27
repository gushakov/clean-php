<?php

namespace ExampleApp\Infrastructure\Adapter\Db;

use ExampleApp\Core\Model\Author;
use ExampleApp\Core\Model\Greeting;
use ExampleApp\Core\Model\GreetingId;
use ExampleApp\Core\Model\InvalidDomainObjectError;

/**
 * This mapper will convert model entities to and from corresponding
 * persistent entities. Mapping might not be one-to-one. Use cases
 * will only ever operate with model entities.
 */
class PersistenceMapper
{

    /**
     * @throws InvalidDomainObjectError
     */
    function convertFromArrayToAuthor(array $dto): Author
    {
        return new Author($dto['name']);
    }

    function convertFromAuthorToArray(Author $author): array
    {
        return ['name' => $author->getName()];
    }

    /**
     * @throws InvalidDomainObjectError
     */
    function convertFromArrayToGreeting(array $dto): Greeting
    {
        return new Greeting(GreetingId::of($dto['_id']),
            $dto['text'],
            $this->convertFromArrayToAuthor($dto['author']));
    }

    function convertFromGreetingToArray(Greeting $greeting): array
    {
        return [
            'text' => $greeting->getText(),
            'author' => $this->convertFromAuthorToArray($greeting->getAuthor())
        ];
    }

}