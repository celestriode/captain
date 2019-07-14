<?php namespace Celestriode\Captain\Exceptions;

use Celestriode\Captain\ImmutableStringReaderInterface;
use Celestriode\Captain\MessageInterface;

class DynamicCommandExceptionType implements CommandExceptionTypeInterface
{
    /** @var DynamicFunctionInterface $function */
    private $function;

    public function __construct(DynamicFunctionInterface $function)
    {
        $this->function = $function;
    }

    public function create($a): CommandSyntaxException
    {
        return new CommandSyntaxException($this, $this->function->apply($a));
    }

    public function createWithContext(ImmutableStringReaderInterface $reader, $a): CommandSyntaxException
    {
        return new CommandSyntaxException($this, $this->function->apply($a), $reader->getString(), $reader->getCursor());
    }
}