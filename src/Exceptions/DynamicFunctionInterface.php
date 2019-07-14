<?php namespace Celestriode\Captain\Exceptions;

use Celestriode\Captain\MessageInterface;

interface DynamicFunctionInterface
{
    public function apply(...$data): MessageInterface;
}