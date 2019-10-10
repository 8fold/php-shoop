<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;

class ESObject implements Shooped
{
    use ShoopedImp;

    public function isGreaterThan($compare): ESBool {}

    public function isGreaterThanOrEqual($compare): ESBool {}

    public function isLessThan($compare): ESBool {}

    public function isLessThanOrEqual($compare): ESBool {}

    public function multiply($int) {}

    public function isDivisible($value): ESBool {}

// TODO: Tests!!!!!!
//  Really starting to reconsider...
    public function toggle()
    {
        return $this->enumerate()->toggle()->objectUnfolded();
    }

    // Starting to reconsider
    public function enumerate(): ESArray
    {
        $array = (array) $this->value;
        return Shoop::dictionary($array)->enumerate();
    }

    public function plus(...$args)
    {
        // TODO: Need to figure out more about how stdClass works re adding props
        if (Shoop::array($args)->count()->isNotUnfolded(2)) {
            $className = ESDictionary::class;
            $count = Shoop::array($args)->count();
            trigger_error(
                "{$className}::plus() expects two arguments. {$count} given."
            );
        }

        $key = $this->sanitizeType($args[0], ESString::class)->unfold();

        $dict = $this->unfold();
        $dict[$key] = $args[1];
        return Shoop::dictionary($dict);
    }

    public function minus($value)
    {
        $key = Type::sanitizeType($value, ESString::class);
        unset($this->{$key});
        return Shoop::object($this->unfold());
    }

    // TODO: Test
    public function divide($value = null)
    {
        $initial = Shoop::dictionary($this->unfold())->divide();
        return Shoop::dictionary(["properties" => $initial["keys"], "values" => $initial["values"]]);
    }











    public function __construct($object)
    {
        if (is_object($object)) {
            $this->value = $object;

        } elseif (is_a($object, ESObject::class)) {
            $this->value = $object->unfold();

        } else {
            $this->value = new \stdClass();

        }
    }
}
