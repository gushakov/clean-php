<?php

namespace ExampleApp\Core\UserCase\SayHello;

use ExampleApp\Core\Model\Author;
use ExampleApp\Core\Model\Greeting;
use ExampleApp\Core\Model\GreetingId;
use ExampleApp\Core\Port\Output\Db\GreetingPersistenceError;
use ExampleApp\Core\Port\Output\Db\PersistenceGatewayOperationsOutputPort;
use ExampleApp\Core\Port\Presenter\SayHello\SayHelloPresenterOutputPort;
use ExampleApp\Core\UseCase\SayHello\SayHelloUseCase;
use Exception;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class SayHelloUseCaseTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private SayHelloPresenterOutputPort $mockPresenter;
    private PersistenceGatewayOperationsOutputPort $mockGatewayOps;

    protected function setUp(): void
    {
        // mock presenter and gateway
        $this->mockPresenter = Mockery::mock(SayHelloPresenterOutputPort::class);
        $this->mockGatewayOps = Mockery::mock(PersistenceGatewayOperationsOutputPort::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGreetUserSuccessfully(): void
    {

        // make a reference greeting
        $greeting = new Greeting(GreetingId::of(1), "Test", new Author('Test'));

        // return a reference greeting when the mock gateway is
        // called with an argument from an accepted range
        $this->mockGatewayOps->shouldReceive('obtainGreetingById')
            ->withArgs(function (GreetingId $arg) {
                return $this->inRange($arg->getId());
            })
            ->andReturn($greeting);

        // presenter should have been called to present the reference greeting
        $this->mockPresenter->shouldReceive('presentGreetingToUser')
            ->with($greeting);

        // presenter should not have been called to present any errors
        $this->shouldNotPresentAnyErrors();

        // run the use case
        $this->runUseCase();

    }

    /**
     * @return void
     * @throws Exception
     */
    public function testShouldPresentErrorWhenGreetingNotFoundInStore(): void
    {
        // set up the mock to throw an exception when greeting could not
        // be found
        $this->mockGatewayOps->shouldReceive('obtainGreetingById')
            ->withAnyArgs()
            ->andThrow(GreetingPersistenceError::class);

        // presenter should have been called to present the right type of error
        $this->shouldPresentError(GreetingPersistenceError::class);

        // execute the use case
        $this->runUseCase();

    }

    private function shouldNotPresentAnyErrors()
    {
        $this->mockPresenter->shouldNotReceive('presentError');
    }

    private function shouldPresentError($errorType)
    {
        $this->mockPresenter->shouldReceive('presentError')
            ->withArgs(function ($e) use ($errorType) {
                return $e instanceof $errorType;
            });
    }

    private function inRange(int $arg): bool
    {
        return $arg > 0 && $arg <= 5;
    }

    private function runUseCase(bool $withDefaultAssertion = true): void
    {
        // make an instance of the use case by providing mock presenter
        // and mock gateway
        $useCase = new SayHelloUseCase($this->mockPresenter, $this->mockGatewayOps);

        // execute the use case
        $useCase->greetUser();

        if ($withDefaultAssertion) {
            $this->assertTrue(true);
        }
    }

}