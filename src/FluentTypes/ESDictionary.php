<?php

namespace Eightfold\Shoop\FluentTypes;

use Eightfold\Shoop\FluentTypes\Interfaces\Shooped;
use Eightfold\Shoop\FluentTypes\Traits\ShoopedImp;

use Eightfold\Shoop\FluentTypes\Contracts\Typeable;
use Eightfold\Shoop\FluentTypes\Contracts\TypeableImp;

use Eightfold\Shoop\FluentTypes\Helpers\{

    PhpAssociativeArray
};

class ESDictionary implements
    Shooped,
    Typeable
    // MathOperations,
    // Toggle,
    // Sort,
    // Wrap,
    // Drop,
    // Has,
    // IsIn,
    // Each
{
    use ShoopedImp, TypeableImp;//, MathOperationsImp, ToggleImp, SortImp, WrapImp, DropImp, HasImp, IsInImp, EachImp;

    static public function to(ESDictionary $instance, string $className)
    {
        if ($className === ESArray::class) {
            return PhpAssociativeArray::toIndexedArray($instance->main());

        } elseif ($className === ESBool::class) {
            return PhpAssociativeArray::toBool($instance->main());;

        } elseif ($className === ESDictionary::class) {
            return $instance->main();

        } elseif ($className === ESInt::class) {
            return PhpAssociativeArray::toInt($instance->main());

        } elseif ($className === ESJson::class) {
            return PhpAssociativeArray::toJson($instance->main());

        } elseif ($className === ESObject::class) {
            return PhpAssociativeArray::toObject($instance->main());

        } elseif ($className === ESString::class) {
            return PhpAssociativeArray::toString($instance->main());

        }
    }

    static public function processedMain($main): array
    {
        if (is_array($main) && Type::isDictionary($main)) {
            $main = $main;

        } elseif (is_a($main, ESDictionary::class)) {
            $main = $main->unfold();

        } else {
            $main = [];

        }
        return $main;
    }

    public function interleave(): ESArray
    {
        $build = [];
        foreach ($this->main as $member => $value) {
            $build[] = $value;
            $build[] = $member;
        }
        return Shoop::this($build);
    }
}
