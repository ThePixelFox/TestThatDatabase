<?php

namespace crystlbrd\TestThatDatabase;

trait TestThatDatabaseTrait
{
    /**
     * @var ConnectionsRelay $Connections Connection Relay
     */
    private $Connections;

    private function ttd_createConnectionRelay(): void
    {
        // relay already created?
        if ($this->Connections == null) {
            // create
            $this->Connections = new ConnectionsRelay();
        }
    }

    private function addConnection(string $name, IConnection $connection, array $options = [])
    {
        // open relay if needed
        $this->ttd_createConnectionRelay();

        // add connection
        $this->Connections->add($connection, $options);
    }

    private function removeConnection(string $name)
    {
        // open relay to prevent errors
        $this->ttd_createConnectionRelay();

        // remove connection
        $this->Connections->remove($name);
    }

    private function createTable(string $table): TableCreator
    {
        # TODO
    }

    private function fill(string $table): TableFiller
    {
        # TODO
    }
}