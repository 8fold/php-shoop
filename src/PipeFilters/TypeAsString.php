<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

class TypeAsString extends Filter
{
    private $glue = "";

    public function __construct(string $glue = "")
    {
        $this->glue = $glue;
    }

    public function __invoke($using): string
    {
        if (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return $using;

        } elseif (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return ($using) ? "true" : "false";

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            return strval($using);

        } elseif (TypeIs::applyWith("collection")->unfoldUsing($using)) {
            if (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
                $using = TypeAsDictionary::apply()->unfoldUsing($using);
            }
            $strings = array_filter($using, "is_string"); // TODO: Move to Minus
            return implode($this->glue, $strings);

        }
    }
}
