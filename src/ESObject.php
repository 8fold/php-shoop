<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\{
    Foldable,
    Convertable,
    Checks
};

use Eightfold\Shoop\Interfaces\Shooped;

class ESObject implements Shooped
{
    use Foldable, Convertable, Checks;

    public function __construct($object)
    {
        if (is_object($object)) {
            $this->value = $object;

        } elseif (is_a($object, ESObject::class)) {
            $this->value = $object->unfold();

        } else {
            $this->value = new \stdClass();

        }
    }
}
