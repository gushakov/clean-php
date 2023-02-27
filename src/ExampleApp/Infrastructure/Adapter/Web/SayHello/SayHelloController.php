<?php
declare(strict_types=1);


namespace ExampleApp\Infrastructure\Adapter\Web\SayHello;



use ExampleApp\Core\UseCase\SayHello\SayHelloInputPort;

/**
 * Controller will be invoked by the dispatcher. It should have
 * an instance of a use case injected by the DI container. Controller
 * should ONLY call a use case. There should be no other logic
 * in the controller. All business logic is in the use case. There
 * is no need to return anything from the use case. It is the job
 * of the Presenter (called from the use case) to communicate back
 * to the caller.
 */
class SayHelloController
{
    private SayHelloInputPort $useCase;

    public function __construct(SayHelloInputPort $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(): void
    {

        $this->useCase->greetUser();
    }
}
