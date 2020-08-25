<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

interface Debuggable
{
    public function __debugInfo(): array;
}
