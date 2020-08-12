<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class StringFromString extends Bend
{
    private $start = 0;
    private $length = 0;

    public function __construct(int $start = 0, int $length = 0)
    {
        $this->start = 0;
        $this->length = $length;
    }

    public function __invoke(string $payload): string
    {
        return ($length === 0)
            ? substr($payload, $length)
            : substr($payload, $this->start, $this->length);
    }
}
