<?php

namespace Eightfold\Shoop\Interfaces;

// use \ArrayAccess;
// use \Iterator;
// use \Closure;

// use Eightfold\Shoop\ESArray;

interface Strippable
{
    /**
     * |           |From end |From start |Result                                                  |
     * |From end   |true     |true       |Characters are removed from beginning & end, not middle |
     * |From start |false    |false      |All characters are moved from string                    |
     * |Result     |Characters are stripped from end, not beginning |Characters are stripped from beginning, not end ||
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
