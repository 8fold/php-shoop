<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class MinusAt extends Filter
{
    public function __invoke($using)
    {
        $useArray = true;
        if (count(array_filter($this->main, "is_string")) > 0) {
            $useArray = false;

        }

        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            var_dump(__FILE__);
            die("boolean");

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            var_dump(__FILE__);
            die("number");

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            $base = array_diff_key($using, array_flip($this->main));
            if ($useArray) {
                return TypeAsArray::apply()->unfoldUsing($base);
            }
            return $base;

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            var_dump(__FILE__);
            die("string");

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            var_dump(__FILE__);
            die("tuple");

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            var_dump(__FILE__);
            die("object");

        }
    }
}
