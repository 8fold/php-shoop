<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\PullFirst;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\PullFirst;
use Eightfold\Shoop\PipeFilters\IsJson;

class FromJson extends Filter
{
    private $length = 1;

    public function __construct(int $length = 1)
    {
        $this->length = $length;
    }

    public function __invoke(string $payload): array
    {
        $isJson = Shoop::pipe($payload, IsJson::apply())->unfold();
        if (! $isJson) { return []; }

        return Shoop::pipe($payload,
            AsDictionary::apply(),
            PullFirst::applyWith($this->length)
        )->unfold();
    }
}
