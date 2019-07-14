<?php namespace Celestriode\Captain\Exceptions;

use Celestriode\Captain\MessageInterface;
use Celestriode\Captain\LiteralMessage;

class BuiltInExceptions implements BuiltInExceptionProviderInterface
{
    public function doubleTooLow(): Dynamic2CommandExceptionType
	{
		return new Dynamic2CommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Double must not be less than ' . $data[1] . ', found ' . $data[0]);
            }
        });
    }
    
    public function doubleTooHigh(): Dynamic2CommandExceptionType
	{
		return new Dynamic2CommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Double must not be more than ' . $data[1] . ', found ' . $data[0]);
            }
        });
	}

    public function floatTooLow(): Dynamic2CommandExceptionType
	{
		return new Dynamic2CommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Float must not be less than ' . $data[1] . ', found ' . $data[0]);
            }
        });
	}

    public function floatTooHigh(): Dynamic2CommandExceptionType
	{
		return new Dynamic2CommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Float must not be more than ' . $data[1] . ', found ' . $data[0]);
            }
        });
	}

    public function integerTooLow(): Dynamic2CommandExceptionType
	{
		return new Dynamic2CommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Integer must not be less than ' . $data[1] . ', found ' . $data[0]);
            }
        });
	}

    public function integerTooHigh(): Dynamic2CommandExceptionType
	{
		return new Dynamic2CommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Integer must not be more than ' . $data[1] . ', found ' . $data[0]);
            }
        });
	}

    public function longTooLow(): Dynamic2CommandExceptionType
	{
		return new Dynamic2CommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Long must not be less than ' . $data[1] . ', found ' . $data[0]);
            }
        });
	}

    public function longTooHigh(): Dynamic2CommandExceptionType
	{
		return new Dynamic2CommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Long must not be more than ' . $data[1] . ', found ' . $data[0]);
            }
        });
	}

    /**
     * Creates a simple command exception type with the provided string.
     *
     * @param string $string The literal message with no extra parameters.
     * @return SimpleCommandExceptionType
     */
    final private function createSimple(string $string): SimpleCommandExceptionType
    {
        return new SimpleCommandExceptionType(new LiteralMessage($string));
    }

    public function readerExpectedStartOfQuote(): SimpleCommandExceptionType
	{
        return $this->createSimple('Expected quote to start a string');
	}

    public function readerExpectedEndOfQuote(): SimpleCommandExceptionType
	{
        return $this->createSimple('Unclosed quoted string');
	}

    public function readerExpectedInt(): SimpleCommandExceptionType
	{
        return $this->createSimple('Expected integer');
	}

    public function readerExpectedLong(): SimpleCommandExceptionType
	{
		return $this->createSimple('Expected long');
	}

    public function readerExpectedDouble(): SimpleCommandExceptionType
	{
        return $this->createSimple('Expected double');
	}

    public function readerExpectedFloat(): SimpleCommandExceptionType
	{
		return $this->createSimple('Expected float');
	}

    public function readerExpectedBool(): SimpleCommandExceptionType
	{
		return $this->createSimple('Expected bool');
	}

    public function dispatcherUnknownCommand(): SimpleCommandExceptionType
	{
		return $this->createSimple('Unknown command');
	}

    public function dispatcherUnknownArgument(): SimpleCommandExceptionType
	{
		return $this->createSimple('Incorrect argument for command');
	}

    public function dispatcherExpectedArgumentSeparator(): SimpleCommandExceptionType
	{
		return $this->createSimple('Expected whitespace to end one argument, but found trailing data');
	}

    public function literalIncorrect(): DynamicCommandExceptionType
	{
		return new DynamicCommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Expected literal ' . $data[0]);
            }
        });
	}

    public function readerInvalidEscape(): DynamicCommandExceptionType
	{
		return new DynamicCommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Invalid escape sequence "' . $data[0] . '" in quoted string');
            }
        });
	}

    public function readerInvalidBool(): DynamicCommandExceptionType
	{
		return new DynamicCommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Invalid bool, expected true or false but found "' . $data[0] . '"');
            }
        });
	}

    public function readerInvalidInt(): DynamicCommandExceptionType
	{
		return new DynamicCommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Invalid integer "' . $data[0] . '"');
            }
        });
	}

    public function readerInvalidLong(): DynamicCommandExceptionType
	{
		return new DynamicCommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Invalid long "' . $data[0] . '"');
            }
        });
	}

    public function readerInvalidDouble(): DynamicCommandExceptionType
	{
		return new DynamicCommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Invalid double "' . $data[0] . '"');
            }
        });
	}

    public function readerInvalidFloat(): DynamicCommandExceptionType
	{
		return new DynamicCommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Invalid float "' . $data[0] . '"');
            }
        });
	}

    public function readerExpectedSymbol(): DynamicCommandExceptionType
	{
		return new DynamicCommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Expected "' . $data[0] . '"');
            }
        });
	}

    public function dispatcherParseException(): DynamicCommandExceptionType
	{
		return new DynamicCommandExceptionType(new class implements DynamicFunctionInterface {
            public function apply(...$data): MessageInterface
            {
                return new LiteralMessage('Could not parse command: ' . $data[0]);
            }
        });
	}
}