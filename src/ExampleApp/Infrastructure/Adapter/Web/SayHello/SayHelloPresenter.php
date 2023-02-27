<?php
declare(strict_types=1);

namespace ExampleApp\Infrastructure\Adapter\Web\SayHello;

use ExampleApp\Core\Model\Greeting;
use ExampleApp\Core\UseCase\SayHello\SayHelloPresenterOutputPort;
use ExampleApp\Infrastructure\Adapter\Web\AbstractWebPresenter;

/**
 * Presenter, implements an output port. Will present results of use case execution
 * back to the caller. This is a web presenter which will leverage template processing
 * engine, but it could be a Presenter which outputs to console, for example.
 */
class SayHelloPresenter extends AbstractWebPresenter implements SayHelloPresenterOutputPort
{

    public function presentGreetingToUser(Greeting $greeting): void
    {

        /*
         * The primary job of the Presenter is to "prepare the data for the view"
         * (Nicolas De Boose, vidéo). All the transformations (projections) of the
         * models coming in from the use case will be done here.
         */

        $this->presentTemplatedResponse('hello.html', [
            'text' => $greeting->fullGreetingMessage()
        ]);
    }
}