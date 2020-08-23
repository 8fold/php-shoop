<?php

namespace Eightfold\Shoop;

use Eightfold\Foldable\Pipe;
use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\PipeFilters\TypeIs;

use Eightfold\Shoop\FluentTypes\Contracts\Shooped;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESTuple;
use Eightfold\Shoop\FluentTypes\ESString;

class Shoop
{
    static public function pipe($using, callable ...$elbows): Pipe
    {
        return Pipe::fold($using, ...$elbows);
    }

    static public function this($potential, string $shoopType = ""): Shooped
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($potential)) {
            return ESBoolean::fold($potential);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($potential)) {
            return ESString::fold($potential);

        } elseif (TypeIs::applyWith("integer")->unfoldUsing($potential)) {
            return ESInteger::fold($potential);

        } elseif (TypeIs::applyWith("array")->unfoldUsing($potential)) {
            return ESArray::fold($potential);

        } elseif (TypeIs::applyWith("dictionary")->unfoldUsing($potential)) {
            return ESDictionary::fold($potential);

        } elseif (TypeIs::applyWith("json")->unfoldUsing($potential)) {
            return ESJson::fold($potential);

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($potential)) {
            return ESTuple::fold($potential);

        }
        return $potential;
    }

    // TODO: PHP 8.0 array|ESArray
    /**
     * @deprecated
     */
    static public function array($array): ESArray
    {
        return static::this($array, ESArray::class);
    }

    // TODO: PHP 8.0 bool|ESBoolean
    /**
     * @deprecated
     */
    static public function bool($bool): ESBoolean
    {
        return static::this($bool, ESBoolean::class);
    }

    // TODO: PHP 8.0 dictionary|ESDictionary
    /**
     * @deprecated
     */
    static public function dictionary($assocArray): ESDictionary
    {
        return static::this($assocArray, ESDictionary::class);
    }

    // TODO: PHP 8.0 int|ESInteger
    /**
     * @deprecated
     */
    static public function int($int): ESInteger
    {
        return static::this($int, ESInteger::class);
    }

    // TODO: PHP 8.0 string|ESString
    /**
     * @deprecated
     */
    static public function json($json): ESJson
    {
        return static::this($json, ESJson::class);
    }

    // TODO: PHP 8.0 object|ESTuple
    /**
     * @deprecated
     */
    static public function object($object): ESTuple
    {
        return static::this($object, ESTuple::class);
    }

    // TODO: PHP 8.0 string|ESString
    /**
     * @deprecated
     */
    static public function string($string): ESString
    {
        return static::this($string, ESString::class);
    }
}
