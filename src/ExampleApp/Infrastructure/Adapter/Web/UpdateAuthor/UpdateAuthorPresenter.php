<?php

namespace ExampleApp\Infrastructure\Adapter\Web\UpdateAuthor;

use ExampleApp\Core\Model\GreetingId;
use ExampleApp\Core\UseCase\UpdateAuthor\UpdateAuthorPresenterOutputPort;
use ExampleApp\Infrastructure\Adapter\Web\AbstractWebPresenter;

class UpdateAuthorPresenter extends AbstractWebPresenter implements UpdateAuthorPresenterOutputPort
{

    public function presentEditAuthorOfGreetingView()
    {
        $this->presentTemplatedResponse('edit-author.html');
    }

    public function presentAuthorUpdatedSuccessfully(GreetingId $greetingId)
    {
        $this->presentTemplatedResponse('update-author-success.html',
        [
            'greetingId' => $greetingId->getId()
        ]);
    }
}