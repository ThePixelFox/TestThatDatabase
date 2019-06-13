<?php

namespace TestThatDatabase;

use PDO;
use PDOException;

class Connection
{
    private $Connected;

    private static $Connection;
    private $Parser;

    private $Name;

    private $Host;
    private $User;
    private $Pass;
    private $DbName;
    private $Encoding;
    private $Port;
    private $Driver;

    public function __construct($name)
    {
        $this->Name = $name;

        // set defaults
        $this->Host = 'localhost';
        $this->User = 'root';
        $this->Pass = '';
        $this->DbName = '';
        $this->Encoding = 'utf8mb4';
        $this->Port = 3306;
        $this->Driver = 'mysql';

        // internal variables
        self::$Connection = null;
        $this->Parser = null;

        // status variables
        $this->Connected = false;

        // init SQL Parser
        $this->initParser();
    }

    private function init() {
        if (!$this->Connected) {
            $this->openConnection();
        }
    }


    /// Internal SQL parser handling

    private function driverAvailable($driver)
    {
        $driverFile = dirname(__DIR__) . '/Drivers/' . $driver . '.php';
        return file_exists($driverFile);
    }

    private function initParser() {
        if ($this->driverAvailable($this->Driver)) {
            $namespace = 'TestThatDatabase\\Drivers\\';
            $classname = $namespace . $this->Driver . '.php';

            $this->Parser = new $classname();
        } else {
            throw new Exception('Driver ' . $this->Driver . ' currently not available!');
        }
    }


    /// Database connection handling

    private function openConnection()
    {
        try {
            // Open PDO connection
            self::$Connection = new PDO($this->Driver . ':host=' . $this->Host . ';dbname=' . $this->DbName . $databaseEncodingenc, $this->User, $this->User);

            // Update connection status
            $this->Connected = true;

            // Update connection in parser
            $this->Parser->updateConnection(self::$Connection);
        } catch (PDOException $e) {
            throw new Exception('Failed to connect to ' . $this->Name . '!', 0, $e);
        }
    }

    private function closeConnection()
    {
        $this->Connected = false;
        self::$Connection = null;
    }


    /// Setters

    public function setHost($host)
    {
        $this->closeConnection();
        $this->Host = $host;
    }

    public function setUser($user)
    {
        $this->closeConnection();
        $this->User = $user;
    }

    public function setPassword($pass)
    {
        $this->closeConnection();
        $this->Pass = $pass;
    }

    public function setDatabase($dbname)
    {
        $this->closeConnection();
        $this->DbName = $dbname;
    }

    public function setEncoding($encoding)
    {
        $this->closeConnection();
        $this->Encoding = $encoding;
    }

    public function setPort($port)
    {
        $this->closeConnection();
        $this->Port = $port;
    }

    public function setDriver($driver)
    {
        $this->closeConnection();
        $this->Driver = $driver;
    }

    /// Public API

    public function tableExists($table)
    {
        // Init connection and parser
        $this->init();

        // Relay request to parser
        return $this->Parser->tableExists($table);
    }
}