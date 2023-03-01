<?php

namespace ExampleApp\Infrastructure\Adapter\Web\Controller\UpdateAuthor;

use ExampleApp\Core\Port\Input\UpdateAuthor\UpdateAuthorInputPort;
use Psr\Http\Message\ServerRequestInterface;

class UpdateAuthorController
{

    private UpdateAuthorInputPort $useCase;

    /**
     * @param UpdateAuthorInputPort $useCase
     */
    public function __construct(UpdateAuthorInputPort $useCase)
    {
        $this->useCase = $useCase;
    }


    public function __invoke(ServerRequestInterface $request): void
    {

        if ($request->getServerParams()['PATH_INFO'] === '/edit-author') {
            $this->editAuthor();
        } elseif ($request->getServerParams()['PATH_INFO'] === '/update-author') {
            $this->updateAuthor($request);
        }

    }

    private function editAuthor(): void
    {

        $this->useCase->editAuthorOfGreeting();
    }

    private function updateAuthor(ServerRequestInterface $request): void
    {
        // parse input parameters
        $form = $request->getParsedBody();

        // execute use case
        $this->useCase->updateAuthorOfGreeting($form['greetingId'], $form['authorName']);

    }


}