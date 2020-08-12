<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class EqualStrings extends Bend
{
    private $compare = "";

    public function __construct(string $compare = "")
    {
        $this->compare = $compare;
    }

    public function __invoke(string $payload): bool
    {
        return $payload === $this->compare;
    }
}
