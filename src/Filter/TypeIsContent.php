<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\Filter\TypesOf;

class TypeIsContent extends Filter
{
    public function __invoke($using): bool
    {
        if (TypeIsBoolean::apply()->unfoldUsing($using)) {
            return true;

        }
    }
}
