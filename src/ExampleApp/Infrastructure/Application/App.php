<?php
declare(strict_types=1);

/*
    COPYRIGHT DISCLAIMER:
    --------------------

    A lot of code in this project is modified from or directly inspired by
    the excellent example from Kevin Smith: https://github.com/kevinsmith/no-framework

    Here is the related article by Kevin Smith: https://kevinsmith.io/modern-php-without-a-framework/
 */


namespace ExampleApp\Infrastructure\Application;

use DI\ContainerBuilder;
use ExampleApp\Core\Port\Config\ConfigOperationsOutputPort;
use ExampleApp\Core\Port\Db\PersistenceGatewayOperationsOutputPort;
use ExampleApp\Core\Port\Security\SecurityOperationsOutputPort;
use ExampleApp\Core\UseCase\Login\LoginPresenterOutputPort;
use ExampleApp\Core\UseCase\Login\LoginUserInputPort;
use ExampleApp\Core\UseCase\Login\LoginUserUseCase;
use ExampleApp\Core\UseCase\SayHello\SayHelloInputPort;
use ExampleApp\Core\UseCase\SayHello\SayHelloPresenterOutputPort;
use ExampleApp\Core\UseCase\SayHello\SayHelloUseCase;
use ExampleApp\Core\UseCase\UpdateAuthor\UpdateAuthorInputPort;
use ExampleApp\Core\UseCase\UpdateAuthor\UpdateAuthorPresenterOutputPort;
use ExampleApp\Core\UseCase\UpdateAuthor\UpdateAuthorUseCase;
use ExampleApp\Core\UseCase\Welcome\WelcomeInputPort;
use ExampleApp\Core\UseCase\Welcome\WelcomePresenterOutputPort;
use ExampleApp\Core\UseCase\Welcome\WelcomeUseCase;
use ExampleApp\Infrastructure\Adapter\Config\ConfigAdapter;
use ExampleApp\Infrastructure\Adapter\Db\FilePersistenceGateway;
use ExampleApp\Infrastructure\Adapter\Db\PersistenceMapper;
use ExampleApp\Infrastructure\Adapter\Security\SessionBackedSecurityAdapter;
use ExampleApp\Infrastructure\Adapter\Web\Login\LoginController;
use ExampleApp\Infrastructure\Adapter\Web\Login\LoginPresenter;
use ExampleApp\Infrastructure\Adapter\Web\SayHello\SayHelloController;
use ExampleApp\Infrastructure\Adapter\Web\SayHello\SayHelloPresenter;
use ExampleApp\Infrastructure\Adapter\Web\UpdateAuthor\UpdateAuthorController;
use ExampleApp\Infrastructure\Adapter\Web\UpdateAuthor\UpdateAuthorPresenter;
use ExampleApp\Infrastructure\Adapter\Web\Welcome\WelcomeController;
use ExampleApp\Infrastructure\Adapter\Web\Welcome\WelcomePresenter;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Relay\Relay;
use SleekDB\Exceptions\InvalidArgumentException;
use SleekDB\Exceptions\IOException;
use SleekDB\Exceptions\JsonException;
use SleekDB\Store;
use function DI\autowire;
use function DI\create;
use function FastRoute\simpleDispatcher;

class App
{

    public function setupTemplatesProcessor(string $templatesDir): TemplatesProcessor
    {
        return new TwigTemplatesProcessor($templatesDir);
    }

    public function setupResponseEmitter(): ResponseEmitter
    {
        return new SapiResponseEmitter();
    }

    public function setupContainer(TemplatesProcessor $templatesProcessor,
                                   ResponseEmitter    $responseEmitter,
                                   Store              $store): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->useAnnotations(false);
        $containerBuilder->addDefinitions([

            // PSR-7 request and response
            ResponseInterface::class => create(Response::class),
            ServerRequestInterface::class => function () {
                return ServerRequestFactory::fromGlobals();
            },

            // template processor, response emitter, etc.
            TemplatesProcessor::class => $templatesProcessor,
            ResponseEmitter::class => $responseEmitter,

            // persistence store, mapper, etc.
            Store::class => $store,
            PersistenceMapper::class => create(PersistenceMapper::class),
            PersistenceGatewayOperationsOutputPort::class => autowire(FilePersistenceGateway::class),

            // security adapter
            SecurityOperationsOutputPort::class => create(SessionBackedSecurityAdapter::class),

            // configuration adapter
            ConfigOperationsOutputPort::class => create(ConfigAdapter::class),

            // presenters, input ports (par use case)
            WelcomePresenterOutputPort::class => autowire(WelcomePresenter::class),
            WelcomeInputPort::class => autowire(WelcomeUseCase::class),

            SayHelloPresenterOutputPort::class => autowire(SayHelloPresenter::class),
            SayHelloInputPort::class => autowire(SayHelloUseCase::class),

            UpdateAuthorPresenterOutputPort::class => autowire(UpdateAuthorPresenter::class),
            UpdateAuthorInputPort::class => autowire(UpdateAuthorUseCase::class),

            LoginPresenterOutputPort::class => autowire(LoginPresenter::class),
            LoginUserInputPort::class => autowire(LoginUserUseCase::class)

        ]);
        return $containerBuilder->build();
    }

    public function setupRouting(): Dispatcher
    {
        return simpleDispatcher(function (RouteCollector $r) {
            $r->get('/', WelcomeController::class);
            $r->get('/hello', SayHelloController::class);
            $r->get('/edit-author', UpdateAuthorController::class);
            $r->post('/update-author', UpdateAuthorController::class);
            $r->get('/login', LoginController::class);
            $r->post('/process-login', LoginController::class);
        });
    }

    public function setupMiddleware(Dispatcher $routes, ContainerInterface $container): RequestHandlerInterface
    {
        $middlewareQueue[] = new FastRoute($routes);
        $middlewareQueue[] = new RequestHandler($container);
        return new Relay($middlewareQueue);

    }

    public function setupPersistence(string $dbPath): Store
    {
        $store = new Store('greetings', $dbPath,
            ['timeout' => false]);

        // do not reinitialize the store
        if ($store->count() == 0) {
            $this->insertData($store);
        }

        return $store;
    }

    public function run(RequestHandlerInterface $requestHandler, ContainerInterface $container): void
    {

        $request = $container->get(ServerRequestInterface::class);
        $requestHandler->handle($request);
    }

    /**
     * @throws IOException
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    private function insertData(Store $store): void
    {
        $store->updateOrInsert([
            '_id' => 1,
            'text' => 'Hello from the SleekDB! This is as Clean as it gets!',
            'author' => ['name' => 'George']
        ], false);

        $store->updateOrInsert([
            '_id' => 2,
            'text' => 'Who really needs a PHP framework?',
            'author' => ['name' => 'Brad']
        ], false);

        $store->updateOrInsert([
            '_id' => 3,
            'text' => 'Hexagonal and Clean, this is so cool.',
            'author' => ['name' => 'Sam']
        ], false);

        $store->updateOrInsert([
            '_id' => 4,
            'text' => '',
            'author' => ['name' => 'Peter']
        ], false);

    }

}