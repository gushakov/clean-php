<?php

namespace ExampleApp\Infrastructure\Application;
/**
 * Template processor interface to hide the internal implementation
 * details of how the processor actually works. The Presenters will
 * only see this interface.
 */
interface TemplatesProcessor
{
    public function processTemplate(string $template, $args): string;
}