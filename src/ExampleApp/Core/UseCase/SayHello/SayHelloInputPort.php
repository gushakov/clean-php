<?php

namespace ExampleApp\Core\UseCase\SayHello;

/**
 * Input Port (or "Input Boundary", Robert C. Martin) for the Use Case.
 * This port will be called by the Primary Adapters (Controllers) to
 * perform some business operation.
 */
interface SayHelloInputPort
{
    /*
     * We should take great care when naming use cases. All the names
     * should be directly taken from the Ubiquitous Language of the domain
     * of the application.
     */
    public function greetUser(): void;
}