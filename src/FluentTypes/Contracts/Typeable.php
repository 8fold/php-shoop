<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use \Countable;
use \JsonSerializable;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESTuple;
use Eightfold\Shoop\FluentTypes\ESString;

interface Typeable extends Countable, JsonSerializable
{
    public function array(): ESArray;

    public function boolean(): ESBoolean;

    public function dictionary(): ESDictionary;

    public function int(): ESInteger;

    public function count(): int; // Countable

    public function json(): ESJson;

    public function jsonSerialize(): object; // JsonSerializable

    public function object(): ESTuple;

    public function string($arg): ESString;
}
