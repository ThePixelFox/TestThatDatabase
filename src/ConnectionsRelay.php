<?php

namespace crystlbrd\TestThatDatabase;

use crystlbrd\TestThatDatabase\Exceptions\TestThatDatabaseException;

class ConnectionsRelay
{
    /**
     * @var array $Connections Saved Connections
     */
    private $Connections = [];

    public function __get(string $name): ?IConnection
    {
        # TODO
    }

    public function add(IConnection $connection, array $options = []): void
    {
        # TODO
    }

    public function remove(string $name): void
    {
        # TODO
    }
}