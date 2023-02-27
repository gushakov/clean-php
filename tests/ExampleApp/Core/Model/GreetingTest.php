<?php
declare(strict_types=1);

namespace ExampleApp\Core\Model;

use Exception;
use PHPUnit\Framework\TestCase;

class GreetingTest extends TestCase
{

    /**
     * @return void
     * @throws Exception
     */
    public function testCreateValidGreeting(): void
    {

        $greeting = new Greeting(GreetingId::of(1), 'Hello', new Author('Test'));
        $this->assertInstanceOf(Greeting::class, $greeting);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testInvalidGreetingIdThrowsInvalidDomainError(): void
    {
        $this->expectException(InvalidDomainObjectError::class);
        new Greeting(GreetingId::of(0), 'Test', new Author('Test'));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testEmptyTextFailsWithInvalidDomainObjectError(): void
    {
        $this->expectException(InvalidDomainObjectError::class);
        new Greeting(GreetingId::of(1), '', new Author('Test'));
    }

}