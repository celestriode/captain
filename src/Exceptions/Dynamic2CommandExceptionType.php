<?php namespace Celestriode\Captain\Exceptions;

use Celestriode\Captain\ImmutableStringReaderInterface;

class Dynamic2CommandExceptionType implements CommandExceptionTypeInterface
{
    /** @var DynamicFunctionInterface $function */
    private $function;

    public function __construct(DynamicFunctionInterface $function)
    {
        $this->function = $function;
    }

    public function create($a, $b): CommandSyntaxException
    {
        return new CommandSyntaxException($this, $this->function->apply($a, $b));
    }

    public function createWithContext(ImmutableStringReaderInterface $reader, $a, $b): CommandSyntaxException
    {
        return new CommandSyntaxException($this, $this->function->apply($a, $b), $reader->getString(), $reader->getCursor());
    }
}