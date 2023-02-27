<?php

namespace ExampleApp\Core\Port\Output\Db;

use ExampleApp\Core\Model\GenericExampleAppError;

/**
 * Error thrown by the persistence gateway when some persistence operation
 * does not succeed.
 */
class GreetingPersistenceError extends GenericExampleAppError
{

}