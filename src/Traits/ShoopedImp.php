<?php

namespace Eightfold\Shoop\Traits;

use \Closure;

use Eightfold\Shoop\Traits\ShoopedImpExtensions\CompareImp;
use Eightfold\Shoop\Traits\ShoopedImpExtensions\PhpInterfacesImp;
// use Eightfold\Shoop\Traits\ShoopedImpExtensions\PhpMagicMethodsImp;
use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Traits\Foldable;
use Eightfold\Shoop\Traits\FoldableImp;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

use Eightfold\Shoop\Helpers\{
    Type,
    PhpIndexedArray,
    PhpBool,
    PhpAssociativeArray,
    PhpInt,
    PhpJson,
    PhpObject,
    PhpString
};

trait ShoopedImp
{
    use FoldableImp, CompareImp, PhpInterfacesImp;

    protected $dictionary;

    private function juggleTo(string $className) // TODO: should be : Foldable
    {
        $instanceClass = get_class($this); // TODO: PHP 8 allows for $instance::class
        $value = $instanceClass::to($this, $className);
        return $className::fold($value);
    }

    public function array(): ESArray
    {
        return $this->juggleTo(ESArray::class);
    }

    public function bool(): ESBool
    {
        return $this->juggleTo(ESBool::class);
    }

    public function dictionary(): ESDictionary
    {
        return $this->juggleTo(ESDictionary::class);
    }

    public function int(): ESInt
    {
        return $this->juggleTo(ESInt::class);
    }

    public function json(): ESJson
    {
        return $this->juggleTo(ESJson::class);
    }

    public function object(): ESObject
    {
        return $this->juggleTo(ESObject::class);
    }

    public function string(): ESString
    {
        return $this->juggleTo(ESString::class);
    }
}
