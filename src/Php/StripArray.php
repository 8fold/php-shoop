<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class StripArray extends Bend
{
    private $callback;

    public function __construct(callable $callback = null)
    {
        $this->callback = $callback;
    }

    public function __invoke(array $payload): array
    {
        return ($this->callback === null)
            ? array_filter($payload)
            : array_filter($payload, $this->callback);
    }
}
