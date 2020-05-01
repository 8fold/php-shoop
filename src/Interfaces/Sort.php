<?php

namespace Eightfold\Shoop\Interfaces;

interface Sort
{

    // public function sort(?string ...$flags); // 7.4 : self;

    // Does not make sense on ESBool, ESInt
    public function sort($asc = true, $caseSensitive = true);

    // public function sortNum($asc = true, $caseSensitive = true);

    // public function sortPhp($asc = true, $caseSensitive = true);

    // public function sortMembers($asc = true, $caseSensitive = true);

    // public function sortMembersNum($asc = true, $caseSensitive = true);

    // public function sortMembersPhp($asc = true, $caseSensitive = true);
}
