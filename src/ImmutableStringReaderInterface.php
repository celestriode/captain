<?php namespace Celestriode\Captain;

interface ImmutableStringReaderInterface
{
    public function getString(): string;

    public function getRemainingLength(): int;

    public function getTotalLength(): int;

    public function getCursor(): int;

    public function getRead(): string;

    public function getRemaining(): string;

    public function canRead(int $length = 1): bool;

    public function peek(int $offset = 0): string;
}