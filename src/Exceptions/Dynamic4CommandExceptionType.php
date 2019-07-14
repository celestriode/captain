<?php namespace Celestriode\Captain\Exceptions;

use Celestriode\Captain\ImmutableStringReaderInterface;

class Dynamic4CommandExceptionType implements CommandExceptionTypeInterface
{
    /** @var DynamicFunctionInterface $function */
    private $function;

    public function __construct(DynamicFunctionInterface $function)
    {
        $this->function = $function;
    }

    public function create($a, $b, $c, $d): CommandSyntaxException
    {
        return new CommandSyntaxException($this, $this->function->apply($a, $b, $c, $d));
    }

    public function createWithContext(ImmutableStringReaderInterface $reader, $a, $b, $c, $d): CommandSyntaxException
    {
        return new CommandSyntaxException($this, $this->function->apply($a, $b, $c, $d), $reader->getString(), $reader->getCursor());
    }
}