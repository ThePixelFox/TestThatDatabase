<?php

namespace TestThatDatabase;

use PDO;
use PDOException;

abstract class Driver
{
    protected $pdo;

    protected $ParameterCounter;
    protected $Parameters;
    protected $History;

    public function __construct()
    {
        // setup
        $this->pdo = null;

        $this->ParameterCounter = 0;
        $this->Parameters = [];
        $this->History = [];
    }

    final public function updateConnection(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    protected function execute($sql)
    {
        try {
            // Prepare
            $stm = $this->pdo->prepare($sql);

            // Bind all parameters
            foreach ($this->Parameters as $key => $value) {
                $stm->bindValue($key, $value);
                $sql = str_replace($key, $value, $sql);
            }

            // Execute
            $report = [
                'query' => $sql
            ];
            if ($stm->execute()) {
                // save report
                $report['status'] = 'success';
                $this->History[] = $report;

                // return statement
                return $stm;
            } else {
                // Save report
                $report['status'] = 'error';
                $report['error'] = $this->pdo->errorInfo();
                $this->History[] = $report;

                // return plain old false
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception('Failed to execute SQL command!', $e);
        }
    }

    protected function getNewParamName()
    {
        $name = ':param' . $this->ParameterCounter;
        $this->ParameterCounter++;

        return $name;
    }

    protected function registerParam($value)
    {
        // Check, if value not already present
        if (!($name = array_search($value, $this->Parameters, true))) {
            // If not save the value
            $name = $this->getNewParamName();
            $this->Parameters[$name] = $value;
        }

        return $name;
    }

    abstract public function tableExists($tableName);
}