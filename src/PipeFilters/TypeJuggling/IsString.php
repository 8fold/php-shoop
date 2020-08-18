<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsJson;

class IsString extends Filter
{
    /**
     * Whether to include anything passing PHP is_string
     */
    private $anyString = false;

    public function __construct(bool $anyString = false)
    {
        $this->anyString = $anyString;
    }

    public function __invoke($using): bool
    {
        if (! is_string($using)) {
            return false;

        } elseif ($this->anyString) {
            return is_string($using);

        } elseif (IsJson::apply()->unfoldUsing($using)) {
            return false;

        }
        return true;
    }
}
