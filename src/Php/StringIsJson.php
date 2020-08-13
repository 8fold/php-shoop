<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class StringIsJson extends Bend
{
    public function __invoke(string $payload): bool
    {
        $start = Shoop::pipeline($payload, StartsWithString::bendWith("{"))
            ->unfold();
        if (! $start) { return false; }

        $end = Shoop::pipeline($payload, EndsWithString::bendWith("}"))
            ->unfold();
        if (! $end) { return false; }

        // Don't make bends - could result in infinite loop
        if (! is_array(json_decode($payload, true))) {
            return false;
        }

        return json_last_error() === JSON_ERROR_NONE;
    }
}
