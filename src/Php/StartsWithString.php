<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Shoop\Php;

class StartsWithString
{
    private $prefix = "";

    public function __construct(string $prefix = "")
    {
        $this->prefix = $prefix;
    }

    // TODO: PHP 8.0 - string|array
    public function __invoke(string $payload): bool
    {
        // TODO: PHP 8.0 - str_starts_with()
        // TODO:: replace with pipe - stringToInt
        return substr($payload, 0, Php::stringToInt($this->prefix)) === $this->prefix;
    }
}
