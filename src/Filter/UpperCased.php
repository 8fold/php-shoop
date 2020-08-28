<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

// TODO: Test and expand type coverage
class UpperCased extends Filter
{
    private $encoding = "";

    public function __construct(string $encoding = "")
    {
        if (strlen($encoding) === 0) {
            $encoding = mb_internal_encoding();
        }
        $this->encoding = $encoding;
    }

    public function __invoke($using): string
    {
        if (TypeIs::applyWith("collection")->unfoldUsing($using)) {
            $array = TypeAsArray::apply()->unfoldUsing($using);
            $filtered = array_filter($array, "is_string");
            $using = TypeAsString::apply()->unfoldUsing($filtered);

        }
        $string = mb_strtoupper($using, $this->encoding);
        return $string;
    }
}
