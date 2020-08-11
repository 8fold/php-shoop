<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Foldable\Foldable;
use Eightfold\Foldable\FoldableImp;

use Eightfold\Shoop\Interfaces\ShoopedExtensions\PhpInterfaces;
use Eightfold\Shoop\Traits\ShoopedExtensions\PhpMagicMethods;

use Eightfold\Shoop\{
    ESArray,
    ESInt,
    ESBool,
    ESString,
    ESObject,
    ESDictionary,
    ESJson
};

interface Shooped extends Foldable //, PhpInterfaces, PhpMagicMethods
{
    // public function array(): ESArray;

    // public function bool(): ESBool;

    // public function dictionary(): ESDictionary;

    // public function int(): ESInt;

    // public function json(): ESJson;

    // public function object(): ESObject;

    // public function string(): ESString;
}
