<?php

namespace TestThatDatabase\Tests\Units;

use PHPUnit\Framework\TestCase;
use TestThatDatabase\DatabaseTestTrait;
use TestThatDatabase\Exception;

class InitializationTest extends TestCase
{
    use DatabaseTestTrait;

    public function testConnection()
    {
        // Connect to test db 1
        $this->addConnection('test1')
            ->setUser('test1')
            ->setPassword('test1')
            ->setDatabase('test1')
            ->openConnection();

        $this->assertTrue($this->getConnection('test1')->isConnected());

        // Connect to test db 2
        $this->addConnection('test2')
            ->setUser('test2')
            ->setPassword('test2')
            ->setDatabase('test2')
            ->openConnection();

        $this->assertTrue($this->getConnection('test2')->isConnected());

        // Connect to missing database
        $this->expectException(Exception::class);
        $this->addConnection('test3')
            ->setUser('test3')
            ->openConnection();
    }

    /**
     * @depends testConnection
     */
    public function testTableExits()
    {
        $this->assertTrue(
            $this->getConnection('test1')->tableExists('test1')
        );
    }
}