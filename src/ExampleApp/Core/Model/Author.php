<?php

namespace ExampleApp\Core\Model;


class Author
{
    private readonly string $name;

    /**
     * @param string $name
     * @throws InvalidDomainObjectError
     */
    public function __construct(string $name)
    {
        if (empty($name)){
            throw new InvalidDomainObjectError("Author's name must not be empty");
        }
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}