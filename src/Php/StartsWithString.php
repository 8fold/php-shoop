<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Php\IntFromString;

class StartsWithString extends Bend
{
    private $original = "";
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
        $length = Shoop::pipeline($this->prefix, IntFromString::bend())->unfold();
        return Shoop::pipeline($payload,
            StringFromString::bend(0, $length),
            EqualStrings::bend($this->prefix)
        )->unfold();
        // return substr($payload, 0, Php::stringToInt($this->prefix)) === $this->prefix;
    }
}
