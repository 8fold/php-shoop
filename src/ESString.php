<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESBaseType,
    ESInt,
    ESBool
};

use Eightfold\Shoop\Interfaces\{
    Wrappable,
    Equatable,
    Storeable,
    Describable,
    Randomizable,
    EquatableImp,
    StoreableImp,
    DescribableImp,
    RandomizableImp
};

class ESString extends ESBaseType implements
    Wrappable,
    Storeable,
    Describable
{
    use
        StoreableImp,
        DescribableImp;

    /**
     * TODO: Move to ESArray
     *
     * @param  array  $array [description]
     * @param  int    $at    [description]
     * @return [type]        [description]
     */
    static private function bisectArray(ESArray $array, int $at): array
    {
        // bisectAt(int $at): ESTuple
        $left = array_slice($array->unwrap(), 0, $at);
        $right = array_slice($array->unwrap(), $at);

        return array($left, $right);
    }

    private function bisectedArray($at): array
    {
        $at = parent::sanitizeTypeOrTriggerError($at, "integer", ESInt::class)->unwrap();
        return ESString::bisectArray($this->enumerated(), $at);
    }

    public function unwrap(): string
    {
        return $this->value;
    }

    public function enumerated(): ESArray
    {
        return ESArray::wrap(preg_split('//u', $this->value, null, PREG_SPLIT_NO_EMPTY));
    }

    public function count(): ESInt
    {
        return $this->enumerated()->count();
    }

    private function join(array $array): ESString
    {
        return ESString::wrap(implode('', $array));
    }

    public function sorted(): ESString
    {
        return $this->join($this->enumerated()->sorted()->unwrap());
    }

    public function shuffled(): ESString
    {
        return $this->join($this->enumerated()->shuffled()->unwrap());
    }

    public function toggle(): ESString
    {
        return $this->join($this->enumerated()->toggle()->unwrap());
    }

    public function min(): ESString
    {
        return $this->enumerated()->min();
    }

    public function first(): ESString
    {
        return $this->min();
    }

    public function max(): ESString
    {
        return $this->enumerated()->max();
    }

    public function last(): ESString
    {
        return $this->max();
    }


    public function dropFirst($length): ESString
    {
        return $this->join($this->enumerated()->dropFirst($length)->unwrap());
    }

    public function dropLast($length): ESString
    {
        return $this->join($this->enumerated()->dropLast($length)->unwrap());
    }

    public function startsWith($compare): ESBool
    {
        $compare = parent::sanitizeTypeOrTriggerError($compare, "string", ESString::class)
            ->enumerated();
        return $this->enumerated()->startsWith($compare);
    }

    public function endsWith($compare): ESBool
    {
        $compare = parent::sanitizeTypeOrTriggerError($compare, "string", ESString::class)
            ->toggle();
        return $this->toggle()->startsWith($compare);
    }

    public function multipliedBy($multiplier): ESString
    {
        $multiplier = parent::sanitizeTypeOrTriggerError($multiplier, "integer", ESInt::class);
        return ESString::wrap(str_repeat($this->unwrap(), $multiplier->unwrap()));
    }

    public function dividedBy($delimiter): ESArray
    {
        $separator = parent::sanitizeTypeOrTriggerError($delimiter, "string", ESString::class);
        $array = ESArray::wrap(explode($delimiter, $this->unwrap()))->removeEmptyValues();
        return $array;
    }

    public function lowercased(): string
    {
        return mb_strtolower($this->value);
    }

    public function uppercased(): string
    {
        return mb_strtoupper($this->value);
    }

    public function characterAt($at): string
    {
        $at = parent::sanitizeTypeOrTriggerError($at, "integer", ESInt::class)->unwrap();
        $index = $at - 1;
        $array = $this->enumerated()->unwrap();
        return $array[$index];
    }

    public function insert(string $value, int $at): ESString
    {
        $this->replaceSubrange($value, $at);
        return $this;
    }

    public function replaceSubrange(string $value, int $at, int $length = 0): ESString
    {
        list($left, $right) = $this->bisectedArray($at);

        for ($i = 0; $i < $length; $i++) {
            array_shift($right);
        }

        $insertion = ESString::wrap($value)->enumerated()->unwrap();

        $merged = array_merge($left, $insertion, $right);

        $this->value = implode('', $merged);
        return $this;
    }

    public function remove($at): string
    {
        $at = parent::sanitizeTypeOrTriggerError($at, "integer", ESInt::class)->unwrap();
        $char = $this->characterAt($at);

        $array = $this->enumerated()->unwrap();
        $index = $at - 1;
        unset($array[$index]);

        $this->value = implode('', $array);
        return $char;
    }

    public function removeFirst(): string
    {
        return $this->remove(1);
    }

    public function removeLast(): string
    {
        return $this->remove($this->count());
    }

    public function removeSubrange(int $at, int $length): ESString
    {
        for ($i = 0; $i < $length; $i++) {
            $this->remove($at);
        }
        return $this;
    }

//-> plus/minus
    public function plus($string): ESString
    {
        return ESString::wrap($this->unwrap() . parent::sanitizeTypeOrTriggerError($string, "string")->unwrap());
    }

    public function minus($string): ESString
    {
        $needle = parent::sanitizeTypeOrTriggerError($string, "string")->unwrap();
        return ESString::wrap(str_replace($needle, "", $this->unwrap()));
    }
}
