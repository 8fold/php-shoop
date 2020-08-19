<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

interface Toggle
{
    // Does not make sense on ESObject
    // PHP 8.o bool|ESBoolean = $preserveMembers
    public function toggle($preserveMembers = true);
}
