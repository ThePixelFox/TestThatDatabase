<?php

namespace crystlbrd\TestThatDatabase;

use crystlbrd\TestThatDatabase\Interfaces\IConnection;

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
        # TODO v1
    }

    private function fill(string $table): TableFiller
    {
        # TODO v1
    }

    /// ASSERTIONS

    public static function assertTableCreated()
    {
        # TODO v1
    }

    public static function assertTableDeleted()
    {
        # TODO v1
    }

    public static function assertTableAltered()
    {
        # TODO v1
    }

    public static function assertRowInserted()
    {
        # TODO v1
    }

    public static function assertRowUpdated()
    {
        # TODO v1
    }

    public static function assertRowSelected()
    {
        # TODO v1
    }

    public static function assertRowDeleted()
    {
        # TODO v1
    }
}