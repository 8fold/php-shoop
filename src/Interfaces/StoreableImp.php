<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

trait StoreableImp
{
    public function isEmpty(): ESBool
    {
        return ESBool::wrap(empty($this->value));
    }

    public function contains($needle): ESBool
    {
        if (is_array($this->value)) {
            return ESBool::wrap(in_array($needle, $this->value));

        } elseif (is_string($this->value)) {
            return ESBool::wrap(strpos($this->value, $needle));

        }
        return ESBool::wrap(false);
    }
}
