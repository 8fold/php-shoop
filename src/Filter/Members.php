<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\TypeJuggling\IsList;
use Eightfold\Shoop\Filter\TypeJuggling\IsBoolean;
use Eightfold\Shoop\Filter\TypeJuggling\IsNumber;
use Eightfold\Shoop\Filter\TypeJuggling\IsString;
use Eightfold\Shoop\Filter\TypeJuggling\IsTuple;
use Eightfold\Shoop\Filter\TypeJuggling\IsObject;
use Eightfold\Shoop\Filter\TypeJuggling\IsJson;

use Eightfold\Shoop\Filter\Members\FromList;

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
