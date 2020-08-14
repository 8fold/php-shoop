<?php

namespace Eightfold\Shoop\Contracts;

interface Strippable
{
    /**
     * end   - start
     * true  - true : Characters are removed from beginning & end, not middle.
     * false - false: All characters are moved from string.
     * true  - false: Characters are stripped from end, not beginning.
     * false - true : Characters are stripped from beginning, not end.
     */
    public function strip(
        $charMask  = " \t\n\r\0\x0B",
        $fromEnd   = true,
        $fromStart = true
    );

    public function stripTags(...$allow);

    public function stripFirst($length = 1);

    public function stripLast($length = 1);
}
