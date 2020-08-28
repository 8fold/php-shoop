<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class Has extends Filter
{
    public function __invoke($using)
    {
        if (TypeIs::applyWith("list")->unfoldUsing($using)) {
            return in_array($this->main, $using, true);

        }

        return Shoop::pipe($using,
            TypeAsArray::apply(),
            Has::applyWith($this->main)
        )->unfold();
    }
}
