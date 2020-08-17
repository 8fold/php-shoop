<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsJson;

use Eightfold\Shoop\PipeFilters\Reverse\FromList;

class Reverse extends Filter
{
    public function __invoke($using)
    {
        if (IsBoolean::apply()->unfoldUsing($using)) {
            var_dump(__NAMESPACE__);
            die("is bool");

        } elseif (IsNumber::apply()->unfoldUsing($using)) {
            var_dump(__NAMESPACE__);
            die("is number");

        } elseif (IsString::applyWith(true)->unfoldUsing($using)) {
            if (IsJson::apply()->unfoldUsing($using)) {
                var_dump(__NAMESPACE__);
                die("is json");
            }
            var_dump(__NAMESPACE__);
            die("is string");

        } elseif (IsList::apply()->unfoldUsing($using)) {
            return FromList::apply()->unfoldUsing($using);

        } elseif (IsTuple::apply()->unfoldUsing($using)) {
            var_dump(__NAMESPACE__);
            die("is tuple");

        } elseif (IsObject::apply()->unfoldUsing($using)) {
            var_dump(__NAMESPACE__);
            die("is object");
        }
        die("fell through");
        if (is_bool($using)) {
            return ! $using;

        } elseif (is_int($using)) {
            // return Shoop::pipe($using, ToArrayFromInteger::apply())->unfold();

        } elseif (is_object($using)) {
            // ToArrayFromObject

        } elseif (is_array($using)) {
            return array_reverse($using, $this->preserveMembers);

        } elseif (is_string($using)) {
            $isJson = Shoop::pipe($using, StringIsJson::apply())->unfold();
            if ($isJson) {
                // return Shoop::pipe($using, ToArrayFromJson::apply())
                //     ->unfold();
            }
            return Shoop::pipe($using,
                AsArray::apply(),
                Reverse::apply(),
                AsString::apply()
            )->unfold();

        }
        return [];
    }
}
