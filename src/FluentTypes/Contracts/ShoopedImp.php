<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Foldable\Foldable;
use Eightfold\Foldable\FoldableImp;

use Eightfold\Shoop\PipeFilters\Contracts\Countable;

use Eightfold\Shoop\PipeFilters\Contracts\StringableImp;
use Eightfold\Shoop\PipeFilters\Contracts\TupleableImp;
use Eightfold\Shoop\PipeFilters\Contracts\FalsifiableImp;
use Eightfold\Shoop\PipeFilters\Contracts\ArrayableImp;
use Eightfold\Shoop\PipeFilters\Contracts\KeyableImp;
use Eightfold\Shoop\PipeFilters\Contracts\CountableImp;

use Eightfold\Shoop\FluentTypes\ESBoolean;

use Eightfold\Shoop\FluentTypes\Contracts\ComparableImp;
use Eightfold\Shoop\FluentTypes\Contracts\ReversibleImp;
use Eightfold\Shoop\FluentTypes\Contracts\SubtractableImp;

trait ShoopedImp
{
    use FoldableImp, FalsifiableImp, SubtractableImp, ReversibleImp,
        TupleableImp, StringableImp, ArrayableImp, KeyableImp, CountableImp,
        ComparableImp;
        //, CompareImp, PhpInterfacesImp;

    public function __construct($main)
    {
        $this->main = $main;
    }

    public function asBoolean(): Foldable
    {
        if (is_a($this, ESBoolean::class)) {
            return ESBoolean::fold($this->main);
        }
        var_dump(__FILE__);
        var_dump(__LINE__);
        die("not ESBoolean");
    }

    public function asInteger(): Countable
    {
        return ESInteger::fold(0);
    }

    public function asString(string $glue = ""): Foldable
    {
        return ESString::fold("");
    }

    public function asArray(
        $start = 0,
        bool $includeEmpties = true,
        int $limit = PHP_INT_MAX
    ): ESArray
    {
        return ESArray::fold([]);
    }

    public function asDictionary(
        $start = 0,
        $includeEmpties = true,
        int $limit = PHP_INT_MAX
    ): Foldable
    {
        return ESDictionary::fold([]);
    }

    public function asTuple(): Foldable
    {
        return ESTuple::fold(new class{});
    }

    public function asJson(): Foldable
    {
        return ESString::fold('{}');
    }

    //TODO: PHP 8.0 - int|string|ESInteger|ESString
    public function hasMember($member)
    {
        return Shoop::this(
            $this->offsetExists($member)
        );
    }

    public function at($member)
    {
        return Shoop::this(
            $this->offsetGet($member)
        );
    }

    public function plusMember($value, $member)
    {
        $this->offsetSet($member, $value);
        return static::fold($this->main);
    }

    public function minusMember($member)
    {
        $this->offsetUnset($member);
        return static::fold($this->main);
    }
}
