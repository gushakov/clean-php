<?php

namespace ExampleApp\Core\Port\Output\Config;

interface ConfigOperationsOutputPort
{
    public function username(): string;

    // Obviously, not for production use: should at least be a hash.
    public function password(): string;
}