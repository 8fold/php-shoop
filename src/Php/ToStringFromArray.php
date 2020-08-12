<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class ToStringFromArray extends Bend
{
    private $glue = "";

    public function __construct(string $glue = "")
    {
        $this->glue = $glue;
    }

    public function __invoke(array $payload): string
    {
        // TODO: Test directly
        $strings = array_filter($payload, "is_string");
        return implode($strings, $this->glue);
    }
}
