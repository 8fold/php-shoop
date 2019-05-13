<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESBool;

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

class ESString implements
    Wrappable,
    Equatable,
    Storeable,
    Describable,
    Randomizable
{
    use EquatableImp,
        StoreableImp,
        DescribableImp,
        RandomizableImp;

    private $string = '';

    private $value = '';

    static public function wrap(...$args): ESString
    {
        $string = (isset($args[0])) ? $args[0] : "";
        $count = (isset($args[1])) ? $args[1] : 1;
        return static::wrapString($string, $count);
    }

    static public function wrapString(string $string = "", int $count = 1): ESString
    {
        return (new ESString())->append($string, $count);
    }

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

    private function bisectedArray(int $at): array
    {
        return ESString::bisectArray($this->array(), $at);
    }

    public function unwrap(): string
    {
        return $this->value;
    }

    public function array(): ESArray
    {
        return ESArray::wrap(preg_split('//u', $this->value, null, PREG_SPLIT_NO_EMPTY));
    }

    public function split(
        string $separator,
        int $maxSplits = 0,
        bool $removingEmptyValues = true
    ): array {
        $array = explode($separator, $this->value);
        if ($removingEmptyValues) {
            $unsetEmptyValues = array_filter($array);
            $reindexValues = array_values($unsetEmptyValues);
            $array = $reindexValues;
        }

        if ($maxSplits > 0) {
            list($left, $right) = $this->bisectArray($array, $maxSplits);
            $right = implode($separator, $right);
            $array = empty($right) ? $left : array_merge($left, [$right]);
        }
        return $array;
    }

    public function sorted(): array
    {
        $array = $this->array()->unwrap();
        sort($array, SORT_STRING);
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

    public function first(): string
    {
        return $this->characterAt(1);
    }

    public function last(): string
    {
        return $this->characterAt($this->count());
    }

    // public function randomElement(): string
    // {
    //     $at = rand(1, $this->count());
    //     return $this->characterAt($at);
    // }

    public function characterAt(int $at): string
    {
        $index = $at - 1;
        $array = $this->array()->unwrap();
        return $array[$index];
    }

    public function startsWith(string $prefix): ESBool
    {
        $compare = ESString::wrapString($prefix);
        $at = $compare->count();
        list($left, $_) = $this->bisectedArray($at);
        $left = ESString::wrap(implode('', $left));
        return $compare->isSameAs($left);
    }

    public function hasPrefix(string $prefix): ESBool
    {
        return $this->startsWith($prefix);
    }

    public function hasSuffix(string $suffix): ESBool
    {
        $compare = ESString::wrapString($suffix);
        $at = $this->count() - $compare->count();
        list($_, $right) = $this->bisectedArray($at);
        $right = ESString::wrap(implode('', $right));
        return $compare->isSameAs($right);
    }

    // public function isEmpty(): bool
    // {
    //     return empty($this->value);
    // }

    public function count(): int
    {
        return count($this->array()->unwrap());
    }

    public function append(string $value, int $count = 1): ESString
    {
        $this->value .= str_repeat($value, $count);
        return $this;
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

        $insertion = ESString::wrapString($value)->array()->unwrap();

        $merged = array_merge($left, $insertion, $right);

        $this->value = implode('', $merged);
        return $this;
    }

    public function remove(int $at): string
    {
        $char = $this->characterAt($at);

        $array = $this->array()->unwrap();
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

    public function dropFirst(int $length): string
    {
        $this->removeSubrange(1, $length);
        return $this->value;
    }

    public function dropLast(int $length): string
    {
        for ($i = 0; $i < $length; $i++) {
            $this->remove($this->count());
        }
        return $this->value;
    }

    public function popLast(): string
    {
        return $this->dropLast(1);
    }
}
