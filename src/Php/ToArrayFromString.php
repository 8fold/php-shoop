<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

class ToArrayFromString
{
    public function __invoke(string $payload): array
    {
        return preg_split('//u', $payload, -1, PREG_SPLIT_NO_EMPTY);
    }
}
