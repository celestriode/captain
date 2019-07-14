<?php namespace Celestriode\Captain\Exceptions;

interface BuiltInExceptionProviderInterface
{
    public function doubleTooLow(): Dynamic2CommandExceptionType;
    public function doubleTooHigh(): Dynamic2CommandExceptionType;
    public function floatTooLow(): Dynamic2CommandExceptionType;
    public function floatTooHigh(): Dynamic2CommandExceptionType;
    public function integerTooLow(): Dynamic2CommandExceptionType;
    public function integerTooHigh(): Dynamic2CommandExceptionType;
    public function longTooLow(): Dynamic2CommandExceptionType;
    public function longTooHigh(): Dynamic2CommandExceptionType;

    public function readerExpectedStartOfQuote(): SimpleCommandExceptionType;
    public function readerExpectedEndOfQuote(): SimpleCommandExceptionType;
    public function readerExpectedInt(): SimpleCommandExceptionType;
    public function readerExpectedLong(): SimpleCommandExceptionType;
    public function readerExpectedDouble(): SimpleCommandExceptionType;
    public function readerExpectedFloat(): SimpleCommandExceptionType;
    public function readerExpectedBool(): SimpleCommandExceptionType;
    public function dispatcherUnknownCommand(): SimpleCommandExceptionType;
    public function dispatcherUnknownArgument(): SimpleCommandExceptionType;
    public function dispatcherExpectedArgumentSeparator(): SimpleCommandExceptionType;

    public function literalIncorrect(): DynamicCommandExceptionType;
    public function readerInvalidEscape(): DynamicCommandExceptionType;
    public function readerInvalidBool(): DynamicCommandExceptionType;
    public function readerInvalidInt(): DynamicCommandExceptionType;
    public function readerInvalidLong(): DynamicCommandExceptionType;
    public function readerInvalidDouble(): DynamicCommandExceptionType;
    public function readerInvalidFloat(): DynamicCommandExceptionType;
    public function readerExpectedSymbol(): DynamicCommandExceptionType;
    public function dispatcherParseException(): DynamicCommandExceptionType;
}