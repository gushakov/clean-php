<?php

namespace ExampleApp\Core\Port\Presenter\UpdateAuthor;

use ExampleApp\Core\Model\GreetingId;
use ExampleApp\Core\Port\Presenter\ErrorHandlingPresenterOutputPort;

interface UpdateAuthorPresenterOutputPort extends ErrorHandlingPresenterOutputPort
{

    public function presentEditAuthorOfGreetingView();

    public function presentAuthorUpdatedSuccessfully(GreetingId $greetingId);
}