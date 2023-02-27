<?php

namespace ExampleApp\Core\UseCase;

/**
 * Interface common to all Presenters, declares a method for presenting
 * errors.
 */
interface ErrorHandlingPresenterOutputPort
{
    public function presentError(\Throwable $error);
}