<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Interfaces\{
    Wrappable,
    Equatable,
    EquatableImp
};

class ESString implements Wrappable
{
    private $string = '';

    private $value = '';

    static public function wrap(array $array)
    {
        return static::wrapString(implode('', $array));
    }
    static public function wrapString(string $string)
    {
        return static::fromString($string);
    }

    static public function empty(): ESString
    {
        return new ESString();
    }

    static public function fromString(string $initial): ESString
    {
        return ESString::empty()->append($initial);
    }

    static public function byRepeating(string $initial, int $count): ESString
    {
        return ESString::empty()->append($initial, $count);
    }

    static public function fromFile(string $path): ESString
    {
        return ESString::empty()->appendFromFile($path);
    }

    static private function bisectArray(array $array, int $at): array
    {
        $left = array_slice($array, 0, $at);
        $right = array_slice($array, $at);

        return array($left, $right);
    }

    public function unwrap(): string
    {
        return $this->value;
    }

    public function array(): array
    {
        return preg_split('//u', $this->value, null, PREG_SPLIT_NO_EMPTY);
    }

    private function bisectedArray(int $at): array
    {
        return ESString::bisectArray($this->array(), $at);
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
        $array = $this->array();
        sort($array, SORT_STRING);
        return $array;
    }

    public function string(): string
    {
        return $this->value;
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

    public function randomElement(): string
    {
        $at = rand(1, $this->count());
        return $this->characterAt($at);
    }

    public function characterAt(int $at): string
    {
        $index = $at - 1;
        $array = $this->array();
        return $array[$index];
    }

    public function isSameAs(string $compare): bool
    {
        return $this->array() === ESString::fromString($compare)->array();
    }

    public function startsWith(string $prefix): bool
    {
        $compare = ESString::fromString($prefix);
        $at = $compare->count();
        list($left, $_) = $this->bisectedArray($at);
        $left = implode('', $left);
        return $compare->isSameAs($left);
    }

    public function hasPrefix(string $prefix): bool
    {
        return $this->startsWith($prefix);
    }

    public function hasSuffix(string $suffix): bool
    {
        $compare = ESString::fromString($suffix);
        $at = $this->count() - $compare->count();
        list($_, $right) = $this->bisectedArray($at);
        $right = implode('', $right);
        return $compare->isSameAs($right);
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function count(): int
    {
        return count($this->array());
    }

    public function append(string $value, int $count = 1): ESString
    {
        $this->value .= str_repeat($value, $count);
        return $this;
    }

    public function appendFromFile(string $path, int $count = 1): ESString
    {
        $contents = file_get_contents($path);
        $this->append($contents, $count);
        return $this;
    }

    public function insert(string $value, int $at): ESString
    {
        $this->replaceSubrange($value, $at);
        return $this;
    }

    public function insertFromFile(string $path, int $at): ESString
    {
        $insertion = ESString::fromFile($path)->string();
        $this->insert($insertion, $at);
        return $this;
    }

    public function replaceSubrange(string $value, int $at, int $length = 0): ESString
    {
        list($left, $right) = $this->bisectedArray($at);

        for ($i = 0; $i < $length; $i++) {
            array_shift($right);
        }

        $insertion = ESString::fromString($value)->array();

        $merged = array_merge($left, $insertion, $right);

        $this->value = implode('', $merged);
        return $this;
    }

    public function remove(int $at): string
    {
        $char = $this->characterAt($at);

        $array = $this->array();
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
