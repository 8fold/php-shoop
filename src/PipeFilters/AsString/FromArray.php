<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsString;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsArrayOfStrings;

class FromArray extends Filter
{
    private $glue = "";

    public function __construct(string $glue = "")
    {
        $this->glue = $glue;
    }

    public function __invoke(array $using): string
    {
        $stringArray = Shoop::pipe($using, AsArrayOfStrings::apply())
            ->unfold();
        return implode($this->glue, $stringArray);
    }
}
