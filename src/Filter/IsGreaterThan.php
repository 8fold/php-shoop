<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

// TODO: Increase type-safety by using established type-check pattern
class IsGreaterThan extends Filter
{
    private $compare = "";

    public function __construct($compare = "")
    {
        $this->compare = $compare;
    }

    public function __invoke($using): bool
    {
        if (is_string($using) and is_string($this->compare)) {
            return strcmp($using, $this->compare) > 0;

        }
        return $using > $this->compare;
    }
}
