<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

interface Drop
{
    // Does not make sense on ESBool, ESInt
    public function drop(...$members);

    // TODO: php 8.0 int|ESInt = $length
    public function dropFirst($length = 1);

    public function dropLast($length = 1);

    public function noEmpties();
}
