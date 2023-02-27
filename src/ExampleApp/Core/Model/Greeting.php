<?php

namespace ExampleApp\Core\Model;

/**
 * `Greeting` is an entity. It is the root of the aggregate containing
 * two Value Objects: `greetingId` and `author`. It is an immutable
 * entity, we cannot mutate an instance of `Greeting`. We can only
 * obtain a different instance with some updated state. Moreover, it
 * is always in a valid state. It can not be created in an invalid state.
 * And any of its business operations must not leave it in an invalid
 * state.
 */
class Greeting
{

    private readonly GreetingId $greetingId;
    private readonly string $text;
    private readonly Author $author;

    /**
     * Creates a greeting. Upholds aggregate invariant: each
     * greeting must have an ID, a non-empty text and an author.
     * @throws InvalidDomainObjectError
     */
    public function __construct(GreetingId $greetingId,
                                string     $text,
                                Author     $author)
    {
        $this->greetingId = $greetingId;
        if (empty($text)) {
            throw new InvalidDomainObjectError("Greeting must not have an empty text.");
        }
        $this->text = $text;
        $this->author = $author;
    }

    /**
     * @return GreetingId
     */
    public function getGreetingId(): GreetingId
    {
        return $this->greetingId;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return Author
     */
    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function fullGreetingMessage(): string
    {
        return "#{$this->greetingId->getId()}: $this->text (by {$this->author->getName()})";
    }

    /**
     * @throws InvalidDomainObjectError
     */
    public function withAuthorName(string $author): Greeting
    {
        return $this->with(null,
            null,
            new Author($author));
    }

    /**
     * @throws InvalidDomainObjectError
     */
    private function with(GreetingId $greetingId = null,
                          string     $text = null,
                          Author     $author = null): Greeting
    {
        return new Greeting(
            $greetingId ?: $this->greetingId,
            $text ?: $this->text,
            $author ?: $this->author
        );
    }
}