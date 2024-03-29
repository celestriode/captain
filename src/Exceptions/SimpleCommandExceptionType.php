<?php namespace Celestriode\Captain\Exceptions;

use Celestriode\Captain\MessageInterface;
use Celestriode\Captain\ImmutableStringReaderInterface;
use Celestriode\Captain\LiteralMessage;

class SimpleCommandExceptionType implements CommandExceptionTypeInterface
{
    /** @var MessageInterface $message */
    private $message;

    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    public function create(): CommandSyntaxException
    {
        return new CommandSyntaxException($this, $this->message);
    }

    public function createWithContext(ImmutableStringReaderInterface $reader): CommandSyntaxException
    {
        return new CommandSyntaxException($this, $this->message, $reader->getString(), $reader->getCursor());
    }

    public function toString(): string
    {
        return $this->message->getString();
    }
	
	public static function createWithLiteral(string $string): self
	{
		return new self(new LiteralMessage($string));
	}
}