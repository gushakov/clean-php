<?php

namespace ExampleApp\Core\Port\Input\UpdateAuthor;

interface UpdateAuthorInputPort
{
    public function editAuthorOfGreeting();

    public function updateAuthorOfGreeting(int $greetingId, string $updatedAuthorName): void;

}