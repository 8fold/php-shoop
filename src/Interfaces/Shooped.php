<?php

namespace Eightfold\Shoop\Interfaces;

interface Shooped
{
    public function __construct($initial);

    static public function fold($args);

    public function unfold();
}
