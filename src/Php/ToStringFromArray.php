<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class ToStringFromArray extends Bend
{
    private $glue = "";

    public function __construct(string $glue = "")
    {
        $this->glue = $glue;
    }

    public function __invoke(array $payload): string
    {
        // TODO: Test directly
        $strings = Shoop::pipeline($payload, StripArray::bendWith("is_string"))
            ->unfold();
        return implode($strings, $this->glue);
    }
}
