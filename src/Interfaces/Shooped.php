<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\{
    ESArray,
    ESInt,
    ESBool
};

interface Shooped
{
    public function __construct($initial);

    static public function fold($args);

    public function unfold();

// sketch - enumerable
    // TODO: Move Convertable methods to Type and convert to static
    // private function sanitizeType($toSanitize, string $shoopType = "");

    public function enumerate(): ESArray;

    public function toggle(); // 7.4 : self;

    public function count(): ESInt;

    public function countIsGreaterThan($value): ESBool;

    public function countIsNotGreaterThan($value): ESBool;

    public function countIsLessThan($value): ESBool;

    public function countIsNotLessThan($value): ESBool;

// Checks
    public function isEmpty(): ESBool;

    public function isArray(): ESBool;

    public function isNotArray(): ESBool;
    // TODO: consider is() instead of isSame()
    public function isSame($compare): ESBool;

    public function isNot($compare): ESBool;

// Other
    // ESBool not implemented
    public function plus(...$args); // 7.4 : self;

    // ESBool not implemented
    public function append(...$args); // 7.4 : self;

    // ESBool not implemented
    public function prepend(...$args); // 7.4 : self;

    // ESBool not implemented
    public function minus($value); // 7.4 : self;

    // ESBool, ESDictionary, ESObject not implemented
    public function multiply($int); // 7.4 : self;

    // ESBool not implemented
    public function divide($value = null);

    // TODO: Verify this is actually used by AMOS
    // ESBool, ESObject not implemented
    public function isDivisible($value): ESBool; // Left off here....

    // ESArray, ESDictionary, ESObject not implemented
    public function isGreaterThan($compare): ESBool;

    public function isGreaterThanOrEqual($compare): ESBool;

    public function isLessThan($compare): ESBool;

    public function isLessThanOrEqual($compare): ESBool;
}
