<?php

namespace ExampleApp\Infrastructure\Adapter\Config;

use ExampleApp\Core\Port\Output\Config\ConfigOperationsOutputPort;

class ConfigAdapter implements ConfigOperationsOutputPort
{

    // Array of properties for the application.
    // Can also be externalized in a separate file.
    private array $props;

    public function __construct()
    {
        $this->props = [
            'username' => 'user1',
            'password' => 'test'
        ];
    }

    public function username(): string
    {
        return $this->props['username'];
    }

    public function password(): string
    {
        return $this->props['password'];
    }
}

