<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

interface Sort
{
    // Does not make sense on ESBool, ESInt
    // TODO: bool|ESBool
    public function sort($asc = true, $caseSensitive = true);

    // public function sortNum($asc = true, $caseSensitive = true);

    // public function sortPhp($asc = true, $caseSensitive = true);

    public function sortMembers($asc = true, $caseSensitive = true);

    // public function sortMembersNum($asc = true, $caseSensitive = true);

    // public function sortMembersPhp($asc = true, $caseSensitive = true);
}
