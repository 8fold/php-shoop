<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

class ReverseArray extends Filter
{
    private $preserveMembers = true;

    public function __construct(bool $preserveMembers = true)
    {
        $this->preserveMembers = $preserveMembers;
    }

    public function __invoke(array $payload): array
    {
        // TODO: Test directly
        return array_reverse($payload, $this->preserveMembers);
    }
}
