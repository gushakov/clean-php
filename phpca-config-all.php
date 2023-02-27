<?php

/*
    COPYRIGHT DISCLAIMER:
    --------------------

    This file is a copy of a configuration file from original software package:
    php-clean-architecture by Valeriy Chetkov.

    It was copied and modified from
    https://github.com/Chetkov/php-clean-architecture/blob/master/example.phpca-config.php
    following the installation instructions provided in the "README.md".

    License for php-clean-architecture is available at:
    https://github.com/Chetkov/php-clean-architecture/blob/master/LICENSE

    Also, the following example was extensively consulted for this configuration
    https://github.com/Chetkov/php-clean-architecture-example-project/blob/master/phpca-config.php

 */

declare(strict_types=1);

use Chetkov\PHPCleanArchitecture\Infrastructure\Event\EventManager;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Report\ComponentReportRenderingEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Report\ReportBuildingEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Report\ReportRenderingEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Report\UnitOfCodeReportRenderedEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Render\TwigToTemplateRendererInterfaceAdapter;
use Chetkov\PHPCleanArchitecture\Service\EventManagerInterface;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Analysis\AnalysisEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Analysis\ComponentAnalysisEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Analysis\FileAnalyzedEventListener;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CompositeDependenciesFinder;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\CodeParsingDependenciesFinder;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ClassesCalledStaticallyParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ClassesCreatedThroughNewParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ClassesFromInstanceofConstructionParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\MethodAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ParamAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\PropertyAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ReturnAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ThrowsAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\VarAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\DependenciesFinderInterface;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\ReflectionDependenciesFinder;
use Chetkov\PHPCleanArchitecture\Service\Report\DefaultReport\ReportRenderingService;
use Chetkov\PHPCleanArchitecture\Service\Report\ReportRenderingServiceInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [
    // Директория в которую будут складываться файлы отчета
    'reports_dir' => __DIR__ . '/phpca-reports',

    // Учет vendor пакетов (каждый подключенный пакет, за исключением перечисленных в excluded, будет представлен компонентом)
    'vendor_based_components' => [
        'enabled' => false,
        'vendor_path' => __DIR__ . '/vendor',
    ],

    // Общие для всех компонентов ограничения
    'restrictions' => [
        // Включение/отключение обнаружения нарушений принципа ацикличности зависимостей.
        'check_acyclic_dependencies_principle' => true,

        // Включение/отключение обнаружения нарушений принципа устойчивых зависимостей.
        'check_stable_dependencies_principle' => true,

    ],

    // Описание компонентов и их ограничений
    'components' => [

        // model
        [
            'name' => 'model',
            'roots' => [
                [
                    'path' => __DIR__ . '/src/ExampleApp/Core/Model',
                    'namespace' => '\ExampleApp\Core\Model',
                ],
            ],

        ],

        // input ports
        [
            'name' => 'input ports',
            'roots' => [
                [
                    'path' => __DIR__ . '/src/ExampleApp/Core/Port/Input',
                    'namespace' => '\ExampleApp\Core\Port\Input',
                ],
            ],

        ],

        // output ports (sec. adapt.)
        [
            'name' => 'output ports (sec. adapt.)',
            'roots' => [
                [
                    'path' => __DIR__ . '/src/ExampleApp/Core/Port/Output',
                    'namespace' => '\ExampleApp\Core\Port\Output',
                ],
            ],

        ],

        // output ports (presenters)
        [
            'name' => 'output ports (presenters)',
            'roots' => [
                [
                    'path' => __DIR__ . '/src/ExampleApp/Core/Port/Presenter',
                    'namespace' => '\ExampleApp\Core\Port\Presenter',
                ],
            ],

        ],

        // use cases
        [
            'name' => 'use cases',
            'roots' => [
                [
                    'path' => __DIR__ . '/src/ExampleApp/Core/UseCase',
                    'namespace' => '\ExampleApp\Core\UseCase',
                ],
            ],

        ],

        // controllers
        [
            'name' => 'controllers',
            'roots' => [
                [
                    'path' => __DIR__ . '/src/ExampleApp/Infrastructure/Adapter/Web/Controller',
                    'namespace' => '\ExampleApp\Infrastructure\Adapter\Web\Controller',
                ],
            ],

        ],

        // presenters
        [
            'name' => 'presenters',
            'roots' => [
                [
                    'path' => __DIR__ . '/src/ExampleApp/Infrastructure/Adapter/Web/Presenter',
                    'namespace' => '\ExampleApp\Infrastructure\Adapter\Web\Presenter',
                ],
            ],

        ],

        // secondary adapters
        [
            'name' => 'secondary adapters',
            'roots' => [
                [
                    'path' => __DIR__ . '/src/ExampleApp/Infrastructure/Adapter',
                    'namespace' => '\ExampleApp\Infrastructure\Adapter',
                ],
            ],
            'excluded' => [
                __DIR__ . '/src/ExampleApp/Infrastructure/Adapter/Web',
            ],
        ],

        // application
        [
            'is_analyze_enabled' => false,
            'name' => 'application',
            'roots' => [
                [
                    'path' => __DIR__ . '/src/ExampleApp/Infrastructure/Application',
                    'namespace' => '\ExampleApp\Infrastructure\Application',
                ],
            ],
        ],

    ],

    'factories' => [
        //Фабрика, собирающая DependenciesFinder
        'dependencies_finder' => static function (): DependenciesFinderInterface {
            return new CompositeDependenciesFinder(...[
                new ReflectionDependenciesFinder(),
                new CodeParsingDependenciesFinder(...[
                    new ClassesCreatedThroughNewParsingStrategy(),
                    new ClassesCalledStaticallyParsingStrategy(),
                    new ClassesFromInstanceofConstructionParsingStrategy(),
                    new PropertyAnnotationsParsingStrategy(),
                    new MethodAnnotationsParsingStrategy(),
                    new ParamAnnotationsParsingStrategy(),
                    new ReturnAnnotationsParsingStrategy(),
                    new ThrowsAnnotationsParsingStrategy(),
                    new VarAnnotationsParsingStrategy(),
                ]),
            ]);
        },
        //Фабрика, собирающая сервис рендеринга отчетов
        'report_rendering_service' => static function (EventManagerInterface $eventManager): ReportRenderingServiceInterface {
            $templatesLoader = new FilesystemLoader(ReportRenderingService::templatesPath());
            $twigRenderer = new Environment($templatesLoader);
            $twigAdapter = new TwigToTemplateRendererInterfaceAdapter($twigRenderer);
            return new ReportRenderingService($eventManager, $twigAdapter);
        },
        //Фабрика, собирающая и настраивающая EventManager
        'event_manager' => static function (): EventManagerInterface {
            return new EventManager([
                new ReportBuildingEventListener(),
                new AnalysisEventListener(),
                new ComponentAnalysisEventListener(),
                new FileAnalyzedEventListener(),
                new ReportBuildingEventListener(),
                new ReportRenderingEventListener(),
                new ComponentReportRenderingEventListener(),
                new UnitOfCodeReportRenderedEventListener(),
            ]);
        }
    ],
];