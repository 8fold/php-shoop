<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class AsStringWithTags extends Filter
{
    private $allowed = [];

    public function __construct(string ...$allowed)
    {
        $this->allowed = $allowed;
    }

    public function __invoke(string $using): string
    {
        $allow = Shoop::pipe($this->allowed, AsString::apply())->unfold();
        return strip_tags($using, $allow);
    }
}
