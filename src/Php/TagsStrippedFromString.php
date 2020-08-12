<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class TagsStrippedFromString extends Bend
{
    private $allowed = [];

    public function __construct(string ...$allowed)
    {
        $this->allowed = $allowed;
    }

    public function __invoke(string $payload): string
    {
        $allow  = implode("", $this->allowed);
        return strip_tags($payload, $allow);
    }
}
