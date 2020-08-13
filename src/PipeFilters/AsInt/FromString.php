<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsInt;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\AsInt;

class FromString extends Filter
{
    private $stringToInt   = false;
    private $occurrences   = false;
    private $caseSensitive = true;

    public function __construct(
        bool $stringToInt = false,
        bool $occurrences = false,
        bool $caseSensitive = true
    )
    {
        $this->stringToInt = $stringToInt;
        $this->occurrences = $occurrences;
        $this->caseSensitive = $caseSensitive;
    }

    public function __invoke(string $payload): int
    {
        return Shoop::pipe($payload, AsArray::apply(), AsInt::apply())->unfold();
    }
}
