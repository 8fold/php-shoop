<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsInteger;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\AsInteger;
use Eightfold\Shoop\PipeFilters\IsNot;
use Eightfold\Shoop\PipeFilters\AsStringLowerCased;

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

    public function __invoke(string $using): int
    {
        if ($this->stringToInt) {
            return intval($using);

        } elseif (strlen($this->occurrences) > 0) {
            if ($this->caseSensitive) {
                return substr_count($using, $this->occurrences);

            }
            $lPayload = Shoop::pipe($using, AsStringLowerCased::apply())->unfold();
            $lOccurrences = Shoop::pipe($this->occurrences, AsStringLowerCased::apply())
                ->unfold();
            return substr_count($lPayload, $lOccurrences);

        }
        return Shoop::pipe($using, AsArray::apply(), AsInteger::apply())->unfold();
    }
}
