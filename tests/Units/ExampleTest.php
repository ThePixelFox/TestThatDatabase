<?php

/**
 * The purpose of this file is to illustrate the desired and planned
 * behavior of TestThatDatabase (TTD). It illustrates the API in use.
 */

namespace crystlbrd\TestThatDatabase\Tests\Units;

use crystlbrd\TestThatDatabase\Connection;
use crystlbrd\TestThatDatabase\TestThatDatabaseTrait;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    use TestThatDatabaseTrait;

    public static function setUpBeforeClass(): void
    {
        // adding the public database
        self::addConnection('public', new Connection(
            'localhost',
            'root',
            'somePassword',
            'public_db'
        ), [
            'write' => false // set connection to read-only
        ]);

        // adding testing connection
        self::addConnection('test', new Connection(
            'localhost',
            'root',
            'somePassword',
            'test_db'
        ));
    }

    public function copyTableBetweenDatabases()
    {
        // copy table1 from public db to testing db
        $this->createTable('table1')
            ->from($this->Connections->public)
            ->to($this->Connections->test);
    }

    public function createTableFromFile()
    {
        // create table2 from XML file in testing db
        $this->createTable('table2')
            ->from('path/to/create_file.xml')
            ->to($this->Connections->test);
    }

    public function createTableFromArray()
    {
        // create table3 from array in testing db
        $this->createTable('table3')
            ->from([
                'Columns' => [

                    'col1' => [
                        'Type' => 'INT',
                        'Null' => false,
                        'Index' => 'primary_key',
                        'Auto_Increment' => true
                    ],
                    'col2' => [
                        'Type' => 'VARCHAR(256)'
                    ],
                    'ref' => [
                        'Type' => 'INT'
                    ]
                ],
                'ForeignKeys' => [
                    'ref' => [
                        'Table' => 'ref_table',
                        'Column' => 'col_id',
                        'On_Update' => 'action',
                        'On_Delete' => 'action'
                    ]
                ]
            ])
            ->to($this->Connections->test);
    }

    public function fillTableFromDatabase()
    {
        $this->fill('table1')
            ->from($this->Connections->test,
                [
                    'keep_auto_increment_values' => true // copy the AUTO_INCREMENT values from the source table
                ]
            )
            ->with($this->Connections->public);
    }

    public function fillTableFromFile()
    {
        $this->fill('table2')
            ->from($this->Connections->test)
            ->with('path/to/fill_file.xml');
    }

    public function fillTableFromArray()
    {
        $this->fill('table3')
            ->from($this->Connections->test)
            ->with([
                [
                    'col1' => 1,
                    'col2' => 'entry1',
                    'ref' => 42
                ],
                [
                    // col1 is auto_increment
                    // col2 is null by default
                    'ref' => 24
                ]
            ]);
    }

    public function plannedAssertions()
    {
        /**
         * All tables created by $this->createTable() are automatically
         * added to the fixture and are ignored by any table assertion
         */
        $this->copyTableBetweenDatabases();

        /**
         * All rows added by $this->fill() are automatically
         * added to the fixture and are ignored by any row assertion
         */
        $this->fillTableFromDatabase();

        ###
        # some code, which creates a new table and manipulates rows
        ###

        /// TABLES

        // Checks if any new Table has been created inside the test db
        $this->assertTableCreated($this->Connections->test);

        // Checks, if a table named "jeff" has been created inside the test db
        $this->assertTableCreated($this->Connections->test, 'jeff');

        // Checks, if a table named "geoffrey" has been created inside the test db with the given structure
        $this->assertTableCreated($this->Connections->test, 'geoffrey', [/* some blueprint data */]);

        $this->assertTableDeleted();
        $this->assertTableAltered();

        /// ROWS

        $this->assertRowInserted();
        $this->assertRowDeleted();
        $this->assertRowSelected();
        $this->assertRowUpdated();
    }
}