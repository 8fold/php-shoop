<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsDictionary;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsDictionary;

class FromArray extends Filter
{
    private $prefix = "i";

    /**
     * TODO: PHP 8.0 can be accomplished with empty constructor
     */
    public function __construct(string $prefix = "i")
    {
        $this->prefix = $prefix;
    }

    public function __invoke(array $using): array
    {
        $prefix = $this->prefix;
        $prefix = ($prefix !== null and strlen($prefix) > 0) ? $prefix : "i";

        $dictionary = [];
        foreach ($using as $key => $value) {
            $key = $prefix . $key;
            $dictionary[$key] = $value;
        }

        return $dictionary;
    }
}
