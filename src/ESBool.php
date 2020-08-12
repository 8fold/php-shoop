<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpBool
};

use Eightfold\Shoop\ESInt;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Typeable,
    Toggle,
    IsIn
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    TypeableImp,
    ToggleImp,
    IsInImp
};

class ESBool implements Shooped, Typeable//, Toggle, IsIn
{
    use ShoopedImp, TypeableImp;//, ToggleImp, IsInImp;

    // static public function to(ESBool $instance, string $className)
    // {
    //     if ($className === ESArray::class) {
    //         return PhpBool::toIndexedArray($instance->main());

    //     } elseif ($className === ESBool::class) {
    //         return $instance->main();

    //     } elseif ($className === ESDictionary::class) {
    //         return PhpBool::toAssociativeArray($instance->main());

    //     } elseif ($className === ESInt::class) {
    //         return PhpBool::toInt($instance->main());

    //     } elseif ($className === ESJson::class) {
    //         return PhpBool::toJson($instance->main());

    //     } elseif ($className === ESObject::class) {
    //         return PhpBool::toObject($instance->main());

    //     } elseif ($className === ESString::class) {
    //         return PhpBool::toString($instance->main());

    //     }
    // }

    // static public function processedMain($main): bool
    // {
    //     if (is_bool($main)) {
    //         $main = $main;

    //     } elseif (is_a($main, ESBool::class)) {
    //         $main = $main->unfold();

    //     } else {
    //         $main = false;

    //     }
    //     return $main;
    // }
}
