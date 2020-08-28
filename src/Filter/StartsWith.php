<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

class StartsWith extends Filter
{
    private $prefix = "";

    public function __construct($prefix = "")
    {
        $this->prefix = $prefix;
    }

    public function __invoke($using): bool
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            $array = TypeAsArray::apply()->unfoldUsing($using);
            $span  = From::applyWith(
                0,
                TypeAsInteger::apply()->unfoldUsing($this->prefix)
            )->unfoldUsing($array);
            $string = TypeAsString::apply()->unfoldUsing($span);
            return Is::applyWith($this->prefix)->unfoldUsing($string);

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("json")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {

        }
    }
}
