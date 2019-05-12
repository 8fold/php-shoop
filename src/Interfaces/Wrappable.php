<?php

namespace Eightfold\Shoop\Interfaces;

interface Wrappable
{
    static public function wrap(array $array);

    public function unwrap();
}
