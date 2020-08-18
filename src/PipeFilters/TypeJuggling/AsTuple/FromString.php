<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsTuple;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsDictionary;

class FromString extends Filter
{
    public function __invoke(string $using): object
    {
        $class = new stdClass;
        $class->content = $using;
        return $class;
    }
}
