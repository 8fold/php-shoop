<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

class ReverseArray
{
    private $preserveMembers = true;

    public function __construct(bool $preserveMembers = true)
    {
        $this->preserveMembers = $preserveMembers;
    }

    public function __invoke(array $payload, bool $preserveMembers = true): array
    {
        // TODO: Test directly
        return array_reverse($payload, $preserveMembers);
    }
}
