<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\First;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\First;

class FromObject extends Filter
{
    private $length = 1;

    public function __construct(int $length = 1)
    {
        $this->length = $length;
    }

    public function __invoke(object $payload): array
    {
        return Shoop::pipe($payload,
            AsDictionary::apply(),
            First::applyWith($this->length)
        )->unfold();
    }
}
