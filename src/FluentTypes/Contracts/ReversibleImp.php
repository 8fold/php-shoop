<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Shoop\PipeFilters\Reversed;

use Eightfold\Shoop\FluentTypes\Contracts\Shooped;

use Eightfold\Shoop\FluentTypes\Helpers\PhpIndexedArray;
use Eightfold\Shoop\FluentTypes\Helpers\PhpAssociativeArray;
use Eightfold\Shoop\FluentTypes\Helpers\PhpObject;
use Eightfold\Shoop\FluentTypes\Helpers\PhpString;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESString;
use Eightfold\Shoop\FluentTypes\ESTuple;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESDictionary;

trait ReversibleImp
{
    public function reverse(): Shooped
    {
        return static::fold(
            Reversed::apply()->unfoldUsing($this->unfold())
        );
    }

    /**
     * @deprecated
     */
    public function toggle($preserveMembers = true): Foldable
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->arrayUnfolded();
            $array = PhpAssociativeArray::reversed($array, $preserveMembers);
            return Shoop::array($array);

        } elseif (Type::is($this, ESBoolean::class)) {
            $bool = $this->boolUnfolded();
            $bool = ! $bool;
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $dictionary = PhpAssociativeArray::reversed($array, $preserveMembers);
            return Shoop::dictionary($dictionary);

        } elseif (Type::is($this, ESInteger::class)) {
            $int = $this->intUnfolded();
            $int = -1 * $int;
            return Shoop::integer($int);

        } elseif (Type::is($this, ESJson::class)) {
            $object = $this->objectUnfolded();
            $object = PhpObject::reversed($object, $preserveMembers);
            $json = PhpObject::toJson($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESTuple::class)) {
            $object = $this->objectUnfolded();
            $object = PhpObject::reversed($object, $preserveMembers);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            // $string = $this->stringUnfolded();
            // $string = PhpString::reversed($string);
            // return Shoop::string($string);
        }
    }
}
