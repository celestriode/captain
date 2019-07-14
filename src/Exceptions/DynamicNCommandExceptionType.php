<?php namespace Celestriode\Captain\Exceptions;

use Celestriode\Captain\ImmutableStringReaderInterface;

class DynamicNCommandExceptionType implements CommandExceptionTypeInterface
{
    /** @var DynamicFunctionInterface $function */
    private $function;

    public function __construct(DynamicFunctionInterface $function)
    {
        $this->function = $function;
    }

    public function create($a, ...$b): CommandSyntaxException // NOTE: mojang/brigadier actually implements it this way.
    {
        return new CommandSyntaxException($this, $this->function->apply(...$b));
    }

    public function createWithContext(ImmutableStringReaderInterface $reader, ...$b): CommandSyntaxException
    {
        return new CommandSyntaxException($this, $this->function->apply(...$b), $reader->getString(), $reader->getCursor());
    }
}