<?php

namespace ExampleApp\Core\UseCase\UpdateAuthor;

use ExampleApp\Core\Model\GreetingId;
use ExampleApp\Core\UseCase\ErrorHandlingPresenterOutputPort;

interface UpdateAuthorPresenterOutputPort extends ErrorHandlingPresenterOutputPort
{

    public function presentEditAuthorOfGreetingView();

    public function presentAuthorUpdatedSuccessfully(GreetingId $greetingId);
}