<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Is;

class StringStartsWith extends Filter
{
    private $prefix = "";

    public function __construct(string $prefix = "")
    {
        $this->prefix = $prefix;
    }

    public function __invoke(string $using): bool
    {
        $length = AsInteger::apply()->unfoldUsing($this->prefix);
        return Shoop::pipe($using,
            AsArray::apply(),
            PullFirst::applyWith($length),
            AsString::apply(),
            Is::applyWith($this->prefix)
        )->unfold();
    }
}
