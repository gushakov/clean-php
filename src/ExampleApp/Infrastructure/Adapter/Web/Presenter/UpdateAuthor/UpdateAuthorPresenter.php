<?php

namespace ExampleApp\Infrastructure\Adapter\Web\Presenter\UpdateAuthor;

use ExampleApp\Core\Model\GreetingId;
use ExampleApp\Core\Port\Presenter\UpdateAuthor\UpdateAuthorPresenterOutputPort;
use ExampleApp\Infrastructure\Adapter\Web\Presenter\AbstractWebPresenter;

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