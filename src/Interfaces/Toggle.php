<?php

namespace Eightfold\Shoop\Interfaces;

interface Toggle
{
    // Does not make sense on ESObject
    public function toggle($preserveMembers = true); // 7.4 : self;
}
