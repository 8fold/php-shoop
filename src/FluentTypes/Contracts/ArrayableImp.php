<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Shoop\PipeFilters\Contracts\ArrayableImp as PipeArrayableImp;

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

    public function hasMember($member)
    {
        if (Type::is($this, ESDictionary::class, ESJson::class, ESTuple::class)) {
            $member = Type::sanitizeType($member, ESString::class)->unfold();

        } else {
            $member = Type::sanitizeType($member, ESInteger::class)->unfold();

        }

        $value = $this->arrayUnfolded();
        $class = PhpIndexedArray::class;
        if (Type::is($this, ESDictionary::class)) {
            $value = $this->dictionaryUnfolded();
            $class = PhpAssociativeArray::class;

        } elseif (Type::is($this, ESJson::class)) {
            $value = $this->jsonUnfolded();
            $class = PhpJson::class;

        } elseif (Type::is($this, ESTuple::class)) {
            $value = $this->objectUnfolded();
            $class = PhpObject::class;

        } elseif (Type::is($this, ESString::class)) {
            $value = $this->stringUnfolded();
            $class = PhpString::class;

        }
        $bool = $class::hasMember($value, $member);
        return Shoop::this($this->condition($bool, $closure));
    }
}
