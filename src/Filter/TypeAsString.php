<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class TypeAsString extends Filter
{
    private $glue = "";

    public function __construct(string $glue = "")
    {
        $this->glue = $glue;
    }

    public function __invoke($using): string
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return ($using) ? "true" : "false";

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            return strval($using);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) or
            TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return $using;

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            if (TypeIs::applyWith("dictionary")->unfoldUsing($using)) {
                $using = TypeAsDictionary::apply()->unfoldUsing($using);
            }
            $strings = MinusUsing::applyWith("is_string")->unfoldUsing($using);
            // $strings = array_filter($using, "is_string"); // TODO: Move to Minus
            return implode($this->glue, $strings);

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            if (TypeIs::applyWith("jsong")->unfoldUsing($using)) {
                return TypeAsJson::apply()->unfoldUsing($using);
            }
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                TypeAsString::apply()
            )->unfold();
        }
    }
}
