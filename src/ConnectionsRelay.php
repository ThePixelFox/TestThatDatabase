<?php

namespace crystlbrd\TestThatDatabase;

use crystlbrd\TestThatDatabase\Interfaces\IConnection;

class ConnectionsRelay
{
    /**
     * @var array $Connections Saved Connections
     */
    private $Connections = [];

    public function __get(string $name): ?IConnection
    {
        # TODO v1
    }

    public function add(IConnection $connection, array $options = []): void
    {
        # TODO v1
    }

    public function remove(string $name): void
    {
        # TODO v1
    }
}