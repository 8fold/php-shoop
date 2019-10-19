<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Shoop;

trait ToggleImp
{
    public function toggle($preserveMembers = true) // 7.4 : self
    {
        $array = $this->arrayUnfolded();
        $reversed = array_reverse($array);
        return Shoop::array($reversed)->array();
    }
}
