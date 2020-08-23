<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

interface Reversible
{
    public function reverse(): Shooped;

    /**
     * @deprecated
     */
    public function toggle($preserveMembers = true);
}
