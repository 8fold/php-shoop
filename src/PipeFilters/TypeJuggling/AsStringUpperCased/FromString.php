<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsStringUpperCased;

use Eightfold\Foldable\Filter;

class FromString extends Filter
{
    private $encoding = "";

    public function __construct(string $encoding = "")
    {
        if (strlen($encoding) === 0) {
            $encoding = mb_internal_encoding();
        }
        $this->encoding = $encoding;
    }

    public function __invoke(string $using): string
    {
        $string = mb_strtoupper($using, $this->encoding);
        return $string;
    }
}
