<?php

namespace ExampleApp\Infrastructure\Adapter\Web;

use ExampleApp\Core\UseCase\ErrorHandlingPresenterOutputPort;
use ExampleApp\Infrastructure\Application\ResponseEmitter;
use ExampleApp\Infrastructure\Application\TemplatesProcessor;
use Psr\Http\Message\ResponseInterface;
use Throwable;

abstract class AbstractWebPresenter implements ErrorHandlingPresenterOutputPort
{
    protected ResponseInterface $response;
    protected ResponseEmitter $responseEmitter;
    protected TemplatesProcessor $templatesProcessor;

    public function __construct(ResponseInterface  $response,
                                TemplatesProcessor $templatesProcessor,
                                ResponseEmitter    $responseEmitter)
    {
        $this->response = $response;
        $this->responseEmitter = $responseEmitter;
        $this->templatesProcessor = $templatesProcessor;
    }

    public function presentError(Throwable $error)
    {
        // log error
        error_log("Error: {$error->getMessage()}", 4);
        $this->presentTemplatedResponse('error.html', ['message' => $error->getMessage()], 500);
    }

    protected function presentTemplatedResponse(string $template, $args = [], int $status = 200,
                                                string $contentType = 'text/html'): void
    {
        $response = $this->response->withHeader('Content-Type', $contentType)
            ->withStatus($status);

        $body = $this->templatesProcessor->processTemplate($template, $args);

        $response->getBody()->write($body);
        $this->responseEmitter->emit($response);
    }

    protected function redirect(string $redirectUri): void
    {

        header('Location: ' . $redirectUri);

    }
}