<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class StringIsJson extends Filter
{
    public function __invoke(string $payload): bool
    {
        $start = Shoop::pipe($payload, StartsWithString::applyWith("{"))
            ->unfold();
        if (! $start) { return false; }

        $end = Shoop::pipe($payload, EndsWithString::applyWith("}"))
            ->unfold();
        if (! $end) { return false; }

        // Don't make bends - could result in infinite loop
        if (! is_array(json_decode($payload, true))) {
            return false;
        }

        return json_last_error() === JSON_ERROR_NONE;
    }
}
