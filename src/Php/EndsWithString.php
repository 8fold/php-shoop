<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

class EndsWithString
{
    public function __invoke(array $payload): bool
    {
        $string = $payload["string"];
        $suffix = $payload["suffix"];
        $length = strlen($suffix);
        return substr($string, -$length) === $suffix;
    }
}
