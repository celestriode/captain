<?php namespace Celestriode\Captain\Exceptions;

use Celestriode\Captain\ImmutableStringReaderInterface;

class Dynamic3CommandExceptionType implements CommandExceptionTypeInterface
{
    /** @var DynamicFunctionInterface $function */
    private $function;

    public function __construct(DynamicFunctionInterface $function)
    {
        $this->function = $function;
    }

    public function create($a, $b, $c): CommandSyntaxException
    {
        return new CommandSyntaxException($this, $this->function->apply($a, $b, $c));
    }

    public function createWithContext(ImmutableStringReaderInterface $reader, $a, $b, $c): CommandSyntaxException
    {
        return new CommandSyntaxException($this, $this->function->apply($a, $b, $c), $reader->getString(), $reader->getCursor());
    }
}