<?php

namespace TestThatDatabase;

trait DatabaseTestTrait
{
    private static $Connections = [];

    public function addConnection($name)
    {
        // Check, if name already taken
        if (!isset($this->Connections[$name])) {
            self::$Connections[$name] = new Connection($name);
            return self::$Connections[$name];
        } else {
            throw new Exception('Name for connection already taken!');
        }
    }

    public function getConnection($name)
    {
        if (isset(self::$Connections[$name])) {
            return self::$Connections[$name];
        } else {
            return false;
        }
    }


    public function copyTableFromDatabase($origin, $table, $target)
    {
        // check, if both connections are present
        if (($c_origin = $this->getConnection($origin))) {
            if (($c_target = $this->getConnection($target))) {
                // Check table
                $c_origin->tableExists($table);
            } else {
                throw new Exception('Connection to ' . $target . ' not defined!');
            }
        } else {
            throw new Exception('Connection to ' . $origin . ' not defined!');
        }
    }
}