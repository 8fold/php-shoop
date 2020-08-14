<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\PullFirst;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\PullFirst;

class FromObject extends Filter
{
    private $length = 1;

    public function __construct(int $length = 1)
    {
        $this->length = $length;
    }

    public function __invoke(object $using): array
    {
        return Shoop::pipe($using,
            AsDictionary::apply(),
            PullFirst::applyWith($this->length)
        )->unfold();
    }
}
