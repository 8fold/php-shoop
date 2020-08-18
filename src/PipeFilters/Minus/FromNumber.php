<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Minus;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;

class FromNumber extends Filter
{
    private $subtrahend = 0;

    // TODO: PHP 8.0 - int|float
    public function __construct($subtrahend = 0)
    {
        if (IsNumber::apply()->unfoldUsing($subtrahend)) {
            $this->subtrahend = $subtrahend;

        }
    }

    // TODO: PHP 8.0 - int|float
    public function __invoke($using)
    {
        if (! IsNumber::apply()->unfoldUsing($this->subtrahend)) {
            return 0;

        }
        return $using - $this->subtrahend;
    }
}
