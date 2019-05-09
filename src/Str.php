<?php

namespace Eightfold\String;

class Str
{
    private $string = '';

    static public function empty(): Str
    {
        return new Str();
    }

    static public function fromString(string $initial): Str
    {
        return Str::empty()->append($initial);
    }

    static public function byRepeating(string $initial, int $count): Str
    {
        return Str::empty()->append($initial, $count);
    }

    static public function fromFile(string $path): Str
    {
        return Str::empty()->appendFromFile($path);
    }

    static private function bisectArray(array $array, int $at): array
    {
        $left = array_slice($array, 0, $at);
        $right = array_slice($array, $at);

        return array($left, $right);
    }

    public function array(): array
    {
        return preg_split('//u', $this->string, null, PREG_SPLIT_NO_EMPTY);
    }

    private function bisectedArray(int $at): array
    {
        return Str::bisectArray($this->array(), $at);
    }

    public function split(
        string $separator,
        int $maxSplits = 0,
        bool $removingEmptyValues = true
    ): array {
        $array = explode($separator, $this->string);
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
        return $this->string;
    }

    public function lowercased(): string
    {
        return mb_strtolower($this->string);
    }

    public function uppercased(): string
    {
        return mb_strtoupper($this->string);
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
        return $this->array() === Str::fromString($compare)->array();
    }

    public function startsWith(string $prefix): bool
    {
        $compare = Str::fromString($prefix);
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
        $compare = Str::fromString($suffix);
        $at = $this->count() - $compare->count();
        list($_, $right) = $this->bisectedArray($at);
        $right = implode('', $right);
        return $compare->isSameAs($right);
    }

    public function isEmpty(): bool
    {
        return empty($this->string);
    }

    public function count(): int
    {
        return count($this->array());
    }

    public function append(string $value, int $count = 1): Str
    {
        $this->string .= str_repeat($value, $count);
        return $this;
    }

    public function appendFromFile(string $path, int $count = 1): Str
    {
        $contents = file_get_contents($path);
        $this->append($contents, $count);
        return $this;
    }

    public function insert(string $value, int $at): Str
    {
        $this->replaceSubrange($value, $at);
        return $this;
    }

    public function insertFromFile(string $path, int $at): Str
    {
        $insertion = Str::fromFile($path)->string();
        $this->insert($insertion, $at);
        return $this;
    }

    public function replaceSubrange(string $value, int $at, int $length = 0): Str
    {
        list($left, $right) = $this->bisectedArray($at);

        for ($i = 0; $i < $length; $i++) {
            array_shift($right);
        }

        $insertion = Str::fromString($value)->array();

        $merged = array_merge($left, $insertion, $right);

        $this->string = implode('', $merged);
        return $this;
    }

    public function remove(int $at): string
    {
        $char = $this->characterAt($at);

        $array = $this->array();
        $index = $at - 1;
        unset($array[$index]);

        $this->string = implode('', $array);
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

    public function removeSubrange(int $at, int $length): Str
    {
        for ($i = 0; $i < $length; $i++) {
            $this->remove($at);
        }
        return $this;
    }

    public function dropFirst(int $length): string
    {
        $this->removeSubrange(1, $length);
        return $this->string;
    }

    public function dropLast(int $length): string
    {
        for ($i = 0; $i < $length; $i++) {
            $this->remove($this->count());
        }
        return $this->string;
    }

    public function popLast(): string
    {
        return $this->dropLast(1);
    }
}
