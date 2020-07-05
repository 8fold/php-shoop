<?php

namespace Eightfold\Shoop\Traits;

use \Closure;

use Eightfold\Shoop\Traits\ShoopedImpExtensions\CompareImp;
use Eightfold\Shoop\Traits\ShoopedImpExtensions\PhpInterfacesImp;
use Eightfold\Shoop\Traits\ShoopedImpExtensions\PhpMagicMethodsImp;

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

use Eightfold\Shoop\Interfaces\Shooped;
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
    use CompareImp, PhpInterfacesImp, PhpMagicMethodsImp;

    protected $value;

    protected $dictionary;

    static public function fold($args)
    {
        return new static($args);
    }

    public function unfold()
    {
        // Preserve Shoop internally: unfold($preserve = false)
        // only implement if needed; otherwise, we're good.
        $return = (isset($this->temp)) ? $this->temp : $this->value;
        if (Type::isArray($return) || Type::isDictionary($return)) {
            $array = $return;
            $return = [];
            foreach ($array as $member => $value) {
                if (Type::isShooped($value)) {
                    $value = $value->unfold();
                }
                $return[$member] = $value;
            }
        }
        return $return;
    }

    public function value()
    {
        return $this->value;
    }

    public function condition($bool, Closure $closure = null)
    {
        $bool = Type::sanitizeType($bool, ESBool::class);
        $value = $this->value();
        if ($closure === null) {
            $closure = function($bool, $value) {
                return $bool;
            };
        }
        return $closure($bool, Shoop::this($value));
    }

// - Type Juggling
    private function juggleTo(string $className)
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
