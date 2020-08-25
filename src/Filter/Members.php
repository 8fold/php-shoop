<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsList;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsBoolean;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsTuple;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsObject;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsJson;

use Eightfold\Shoop\PipeFilters\Members\FromList;

class Members extends Filter
{
    private $useArray = true;

    public function __construct(bool $useArray = true)
    {
        $this->useArray = $useArray;
    }

    public function __invoke($using)
    {
        if ($this->useArray) {
            $array = TypeAsArray::apply()->unfoldUsing($using);
            return array_keys($array);

        }
        $dictionary = TypeAsDictionary::apply()->unfoldUsing($using);
        return array_keys($dictionary);
    }
}
