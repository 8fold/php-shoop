<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpJson
};

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    MathOperations,
    Sort,
    Toggle,
    Wrap,
    Drop,
    Has,
    IsIn,
    Each
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    MathOperationsImp,
    SortImp,
    ToggleImp,
    WrapImp,
    DropImp,
    HasImp,
    IsInImp,
    EachImp
};

use Eightfold\Shoop\ESDictionary;

class ESJson implements Shooped, MathOperations, Wrap, Drop, Has, IsIn, Each
{
    use ShoopedImp, ToggleImp, MathOperationsImp, SortImp, WrapImp, DropImp, HasImp, IsInImp, EachImp;

    /**
     * @todo Need a solution for the path
     */
    protected $path = "";

    static public function to(ESJson $instance, string $className)
    {
        if ($className === ESArray::class) {
            return PhpJson::toIndexedArray($instance->main());

        } elseif ($className === ESBool::class) {
            return PhpJson::toBool($instance->main());

        } elseif ($className === ESDictionary::class) {
            return PhpJson::toAssociativeArray($instance->main());

        } elseif ($className === ESInt::class) {
            return PhpJson::toInt($instance->main());

        } elseif ($className === ESJson::class) {
            return $instance->main();

        } elseif ($className === ESObject::class) {
            return PhpJson::toObject($instance->main());

        } elseif ($className === ESString::class) {
            return $instance->main();

        }
    }

    static public function processedMain($main): string
	{
		return (Type::isJson($main)) ? $main : '{"valid":false}';
	}
}
