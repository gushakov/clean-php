<?php

namespace ExampleApp\Core\UseCase\UpdateAuthor;

interface UpdateAuthorInputPort
{
    public function editAuthorOfGreeting();

    public function updateAuthorOfGreeting(int $greetingId, string $updatedAuthorName): void;

}