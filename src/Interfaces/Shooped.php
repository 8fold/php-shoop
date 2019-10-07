<?php

namespace Eightfold\Shoop\Interfaces;

interface Shooped
{
    public function __construct($initial);

    static public function fold($args);

    // static public function phpType(Shooped $value);

    public function unfold();
}
