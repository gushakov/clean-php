<?php

namespace ExampleApp\Core\Port\Db;

use ExampleApp\Core\GenericExampleAppError;

/**
 * Error thrown by the persistence gateway when some persistence operation
 * does not succeed.
 */
class GreetingPersistenceError extends GenericExampleAppError
{

}