<?php

namespace ExampleApp\Infrastructure\Application;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigTemplatesProcessor implements TemplatesProcessor
{
    private FilesystemLoader $loader;
    private Environment $twig;

    public function __construct(string $templatesDir)
    {
        $this->loader = new FilesystemLoader($templatesDir);
        $this->twig = new Environment($this->loader);
    }

    public function processTemplate(string $template, $args): string
    {
        return $this->twig->render($template, $args);
    }
}