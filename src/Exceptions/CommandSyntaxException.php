<?php namespace Celestriode\Captain\Exceptions;

use Celestriode\Captain\MessageInterface;
use Exception;

class CommandSyntaxException extends Exception
{
    const CONTEXT_AMOUNT = 15;
    /** @var BuiltInExceptionProviderInterface $builtInExceptions */
    private static $builtInExceptions;

    /** @var CommandExceptionTypeInterface $type */
    private $type;
    /** @var MessageInterface $message */
    private $rawMessage;
    /** @var string $input */
    private $input;
    /** @var int $cursor */
    private $cursor;

    public function __construct(CommandExceptionTypeInterface $type, MessageInterface $message, string $input = null, int $cursor = -1)
    {
        $this->type = $type;
        $this->rawMessage = $message;
        $this->input = $input;
        $this->cursor = $cursor;
        
        parent::__construct($this->buildMessage($message));
    }

    final public static function getBuiltInExceptions(): BuiltInExceptionProviderInterface
    {
        return self::$builtInExceptions ?? self::$builtInExceptions = new BuiltInExceptions();
    }

    private function buildMessage(MessageInterface $rawMessage): string
    {
        $message = $rawMessage->getString();
        $context = $this->getContext();

        if ($context !== null) {

            $message .= ' at position ' . $this->cursor . ': ' . $context;
        }

        return $message;
    }

    public function getRawMessage(): MessageInterface
    {
        return $this->rawMessage;
    }

    public function getContext(): ?string
    {
        if ($this->input === null || $this->cursor < 0) {

            return null;
        }

        $buffer = '';
        $cursor = min(mb_strlen($this->input), $this->cursor);

        if ($cursor > self::CONTEXT_AMOUNT) {

            $buffer .= '...';
        }

        $max = max(0, $cursor - self::CONTEXT_AMOUNT);

        $buffer .= mb_substr($this->input, $max, $cursor - $max);
        $buffer .= '<--[HERE]';

        return $buffer;
    }

    public function getType(): CommandExceptionTypeInterface
    {
        return $this->type;
    }

    public function getInput(): string
    {
        return $this->input;
    }

    public function getCursor(): int
    {
        return $this->cursor;
    }
}