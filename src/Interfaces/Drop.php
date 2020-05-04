<?php

namespace Eightfold\Shoop\Interfaces;

interface Drop
{
    // Does not make sense on ESBool, ESInt
    public function drop(...$members);

    public function dropFirst($length = 1);

    public function dropLast($length = 1);

    public function noEmpties();
}
