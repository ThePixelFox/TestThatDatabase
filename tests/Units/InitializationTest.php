<?php

namespace TestThatDatabase\Tests\Units;

use crystlbrd\TestThatDatabase\TestThatDatabaseTrait;
use PHPUnit\Framework\TestCase;

class InitializationTest extends TestCase
{
    use TestThatDatabaseTrait;

    public function testSomething()
    {
        $this->assertTableCreated();
    }
}