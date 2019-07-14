<?php namespace Celestriode\Captain;

class LiteralMessage implements MessageInterface
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function getString(): string
    {
        return $this->string;
    }

    public function toString(): string
    {
        return $this->string;
    }
}