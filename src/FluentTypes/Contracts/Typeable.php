<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use \Countable;
use \JsonSerializable;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBool;
use Eightfold\Shoop\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInt;
use Eightfold\Shoop\ESJson;
use Eightfold\Shoop\ESObject;
use Eightfold\Shoop\FluentTypes\ESString;

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
