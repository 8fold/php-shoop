<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsInt;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\AsInt;
use Eightfold\Shoop\PipeFilters\IsNot;
use Eightfold\Shoop\PipeFilters\LowerCase;

class FromString extends Filter
{
    private $stringToInt   = false;
    private $occurrences   = "";
    private $caseSensitive = true;

    public function __construct(
        bool $stringToInt = false,
        string $occurrences = "",
        bool $caseSensitive = true
    )
    {
        $this->stringToInt = $stringToInt;
        $this->occurrences = $occurrences;
        $this->caseSensitive = $caseSensitive;
    }

    public function __invoke(string $payload): int
    {
        if ($this->stringToInt) {
            return intval($payload);

        } elseif (strlen($this->occurrences) > 0) {
            if ($this->caseSensitive) {
                return substr_count($payload, $this->occurrences);

            }
            $lPayload = Shoop::pipe($payload, LowerCase::apply())->unfold();
            $lOccurrences = Shoop::pipe($this->occurrences, LowerCase::apply())
                ->unfold();
            return substr_count($lPayload, $lOccurrences);

        }
        return Shoop::pipe($payload, AsArray::apply(), AsInt::apply())->unfold();
    }
}
