<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

class ReverseArray
{
    public function __invoke(array $payload, bool $preserveMembers = true): array
    {
        // TODO: Test directly
        return array_reverse($payload, $preserveMembers);
    }
}
