<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

interface Toggle
{
    // Does not make sense on ESObject
    // PHP 8.o bool|ESBool = $preserveMembers
    public function toggle($preserveMembers = true);
}
