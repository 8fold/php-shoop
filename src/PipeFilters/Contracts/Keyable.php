<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

interface Keyable extends Countable, JsonSerializable
{
    public function dictionary(): Keyable;

    public function efToDictionary(): array;
}
