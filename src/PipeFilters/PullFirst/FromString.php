<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\PullFirst;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\AsString;
use Eightfold\Shoop\PipeFilters\PullFirst;

class FromString extends Filter
{
    private $length = 1;

    public function __construct(int $length = 1)
    {
        $this->length = $length;
    }

    public function __invoke(string $using): string
    {
        return Shoop::pipe($using,
            AsArray::apply(),
            PullFirst::applyWith($this->length),
            AsString::apply()
        )->unfold();
    }
}
