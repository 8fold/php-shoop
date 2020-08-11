<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

class StartsWithString
{
    public function __invoke(array $payload): bool
    {
        $string = $payload["string"];
        $prefix = $payload["prefix"];
        $length = strlen($prefix);
        return substr($string, 0, $length) === $prefix;
    }
}
