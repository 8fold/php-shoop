<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\PullFirst;
use Eightfold\Shoop\PipeFilters\Last;

class IsJson extends Filter
{
    public function __invoke(string $payload): bool
    {
        // Don't use pipe - could result in infinite loop
        $length = strlen($payload);
        if ($length < 2) {
            return false;

        } elseif ($payload[0] !== "{") {
            return false;

        } elseif ($payload[$length - 1] !== "}") {
            return false;

        } elseif (! is_array(json_decode($payload, true))) {
            return false;

        }
        return json_last_error() === JSON_ERROR_NONE;
    }
}
