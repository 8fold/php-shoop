<?php

namespace Eightfold\Shoop\Interfaces;

use \Countable;
use \JsonSerializable;

use Eightfold\Shoop\ESArray;
use Eightfold\Shoop\ESBool;
use Eightfold\Shoop\ESDictionary;
use Eightfold\Shoop\ESInt;
use Eightfold\Shoop\ESJson;
use Eightfold\Shoop\ESObject;
use Eightfold\Shoop\ESString;

interface Typeable extends Countable, JsonSerializable
{
    public function array(): ESArray;

    public function bool(): ESBool;

    public function dictionary(): ESDictionary;

    public function int(): ESInt;

    public function count(): int; // Countable

    public function json(): ESJson;

    public function jsonSerialize(): object; // JsonSerializable

    public function object(): ESObject;

    public function string($arg): ESString;
}
