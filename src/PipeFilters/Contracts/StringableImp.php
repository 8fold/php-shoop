<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\PipeFilters\Contracts\Stringable;

trait StringableImp
{
    public function efToString(string $glue = ""): string
    {
        if (is_a($this, Stringable::class) and is_a($this, Foldable::class)) {
            return $this->asString($glue)->unfold();

        }
        return "";
    }

    public function __toString(): string
    {
        return $this->efToString();
    }
}