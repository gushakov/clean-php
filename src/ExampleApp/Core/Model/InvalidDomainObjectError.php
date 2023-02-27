<?php

namespace ExampleApp\Core\Model;

use ExampleApp\Core\GenericExampleAppError;

/**
 * Exception thrown when an invariant cannot be asserted
 * on the state of an aggregate.
 */
class InvalidDomainObjectError extends GenericExampleAppError
{

}