<?php


namespace crystlbrd\TestThatDatabase;


class Table
{
    protected $Name;

    public function __construct(string $name)
    {
        $this->Name = $name;
    }

    public function from($ressource): self
    {
        # TODO
    }
}