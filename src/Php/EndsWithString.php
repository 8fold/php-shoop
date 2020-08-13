<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class EndsWithString extends Bend
{
    private $suffix = "";

    public function __construct(string $suffix = "")
    {
        $this->suffix = $suffix;
    }

    // TODO: PHP 8.0 array|string
    public function __invoke(string $payload): bool
    {
        // TODO: PHP 8.0 - str_ends_with()
        // TODO: Use pip - stringToInt()->intReversed()
        $length = Shoop::pipeline($this->suffix, ToIntegerFromString::bend())
            ->unfold();
        return Shoop::pipeline($payload,
            StringFromString::bendWith(-$length),
            EqualStrings::bendWith($this->suffix)
        )->unfold();
    }
}
