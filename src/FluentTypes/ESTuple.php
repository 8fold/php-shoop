<?php

namespace Eightfold\Shoop\FluentTypes;

use \stdClass;

use Eightfold\Shoop\FluentTypes\Helpers\{

    PhpObject
};

// TODO: Shooped should probably extend these
use Eightfold\Shoop\FluentTypes\Contracts\Typeable;
use Eightfold\Shoop\FluentTypes\Contracts\TypeableImp;

use Eightfold\Shoop\FluentTypes\Contracts\Comparable;
use Eightfold\Shoop\FluentTypes\Contracts\ComparableImp;

use Eightfold\Shoop\FluentTypes\Interfaces\Shooped;
use Eightfold\Shoop\FluentTypes\Traits\ShoopedImp;

use Eightfold\Shoop\FluentTypes\Interfaces\MathOperations;
use Eightfold\Shoop\FluentTypes\Traits\MathOperationsImp;

use Eightfold\Shoop\FluentTypes\Interfaces\Sort;
use Eightfold\Shoop\FluentTypes\Traits\SortImp;

use Eightfold\Shoop\FluentTypes\Interfaces\Toggle;
use Eightfold\Shoop\FluentTypes\Traits\ToggleImp;

use Eightfold\Shoop\FluentTypes\Interfaces\Wrap;
use Eightfold\Shoop\FluentTypes\Traits\WrapImp;

use Eightfold\Shoop\FluentTypes\Interfaces\Drop;
use Eightfold\Shoop\FluentTypes\Traits\DropImp;

use Eightfold\Shoop\FluentTypes\Interfaces\Has;
use Eightfold\Shoop\FluentTypes\Traits\HasImp;

use Eightfold\Shoop\FluentTypes\Interfaces\IsIn;
use Eightfold\Shoop\FluentTypes\Traits\IsInImp;

use Eightfold\Shoop\FluentTypes\Interfaces\Each;
use Eightfold\Shoop\FluentTypes\Traits\EachImp;

class ESTuple implements Shooped, Typeable, MathOperations, Sort, Toggle, Wrap, Drop, Has, IsIn, Each, Comparable
{
    use ShoopedImp, TypeableImp, MathOperationsImp, SortImp, ToggleImp, WrapImp, DropImp, HasImp, IsInImp, EachImp, ComparableImp;

    static public function to(ESTuple $instance, string $className)
    {
        if ($className === ESArray::class) {
            return PhpObject::toIndexedArray($instance->main());

        } elseif ($className === ESBoolean::class) {
            return PhpObject::toBool($instance->main());

        } elseif ($className === ESDictionary::class) {
            return PhpObject::toAssociativeArray($instance->main());

        } elseif ($className === ESInteger::class) {
            return PhpObject::toInt($instance->main());

        } elseif ($className === ESJson::class) {
            return PhpObject::toJson($instance->main());

        } elseif ($className === ESTuple::class) {
            return $instance->main();

        } elseif ($className === ESString::class) {
            return PhpObject::toString($instance->main());

        }
    }

    static public function processedMain($main): stdClass
    {
        if (is_object($main)) {
            $main = $main;

        } elseif (is_a($main, ESTuple::class)) {
            $main = $main->unfold();

        } elseif (Type::is($main, ESArray::class, ESDictionary::class)) {
            $main = (object) $main->unfold();

        } elseif (is_array($main)) {
            $main = (object) $main;

        } else {
            $main = new stdClass();

        }
        return $main;
    }
}
