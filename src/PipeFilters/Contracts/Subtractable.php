<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\FluentTypes\ESString;

interface Subtractable
{
    /**
     * end   - start
     * true  - true : Characters are removed from beginning & end, not middle.
     * false - false: All characters are moved from string.
     * true  - false: Characters are stripped from end, not beginning.
     * false - true : Characters are stripped from beginning, not end.
     */
    public function minus(
        $charMask  = " \t\n\r\0\x0B",
        $fromEnd   = true,
        $fromStart = true
    );

    // TODO: PHP 8.0 - int|string
    public function minusAt(...$members);

    // Does not make sense on ESBoolean, ESInteger
    /**
     * @deprecated
     */
    public function drop(...$members);

    // TODO: php 8.0 int|ESInteger = $length
    /**
     * @deprecated
     */
    public function dropFirst($length = 1);

    /**
     * @deprecated
     */
    public function dropLast($length = 1);

    /**
     * @deprecated
     */
    public function noEmpties();
}
