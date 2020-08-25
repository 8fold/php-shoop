<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Shoop\PipeFilters\Contracts\ArrayableImp as PipeArrayableImp;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESString;

trait ArrayableImp
{
    use PipeArrayableImp;

    public function has($needle)
    {
        $array = $this->arrayUnfolded();
        $bool = in_array($needle, $array);
        return Shoop::this($this->condition($bool, $closure));
    }

    public function at($member)
    {
        return Shoop::this(
            Apply::at($member)->unfoldUsing($this->main)
        );
    }

    public function hasAt($member)
    {
        return Shoop::this(
            Apply::hasMembers($member)->unfoldUsing($this->main)
        );
    }

    public function plusAt($value, $member)
    {

    }

    public function minusAt($member)
    {

    }
}
