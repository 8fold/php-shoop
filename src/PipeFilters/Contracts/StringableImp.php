<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

trait StringableImp
{
    public function efToString(string $glue = ""): string
    {
        return $this->asString($glue)->unfold();
    }

    public function __toString(): string
    {
        return $this->efToString();
    }
}
