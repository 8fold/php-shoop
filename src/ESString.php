<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpString
};

use Eightfold\Shoop\Interfaces\{
    Shooped,
    MathOperations,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Has,
    Drop,
    IsIn,
    Each
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    MathOperationsImp,
    ToggleImp,
    ShuffleImp,
    WrapImp,
    SortImp,
    HasImp,
    DropImp,
    IsInImp,
    EachImp
};

class ESString implements
    Shooped,
    MathOperations,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Drop,
    Has, // TODO: Consider different implementation (array splits on letters, words become issues)
    IsIn,
    Each
{
    use ShoopedImp, MathOperationsImp, ToggleImp, ShuffleImp, WrapImp, SortImp, HasImp, DropImp, IsInImp, EachImp;

    static public function to(ESString $instance, string $className)
    {
        if ($className === ESArray::class) {
            return PhpString::toIndexedArray($instance->value());

        } elseif ($className === ESBool::class) {
            return PhpString::toBool($instance->value());

        } elseif ($className === ESDictionary::class) {
            return PhpString::toAssociativeArray($instance->value());

        } elseif ($className === ESInt::class) {
            return PhpString::toInt($instance->value());

        } elseif ($className === ESJson::class) {
            return $instance->value();

        } elseif ($className === ESObject::class) {
            return PhpString::toObject($instance->value());

        } elseif ($className === ESString::class) {
            return $instance->value();

        }
    }

    static public function processedMain($main): string
    {
        if (is_string($main)) {
            $main = $main;

        } elseif (is_a($main, ESString::class)) {
            $main = $main->unfold();

        } else {
            $main = "";

        }
        return $main;
    }

    // public function part($start, $length)
    // {

    // }

    public function dropTags(...$allow)
    {
        $allow = implode("", $allow);
        $string = strip_tags($this->main(), $allow);
        return Shoop::string($string);
    }

    public function replace($replacements = [], $caseSensitive = true): ESString
    {
        $replacements = Type::sanitizeType($replacements, ESDictionary::class)->unfold();
        $caseSensitive = Type::sanitizeType($caseSensitive, ESBool::class)->unfold();
        $search = array_keys($replacements);
        $replace = array_values($replacements);
        if ($caseSensitive) {
            $string = str_replace($search, $replace, $this->main());
            return Shoop::string($string);

        }
        $string = str_ireplace($search, $replace, $this->main());
        return Shoop::string($string);
    }

    public function replaceRange($replacement, $start = 0, $length = null)
    {
        $replacement = Type::sanitizeType($replacement, ESString::class)->unfold();
        $start = Type::sanitizeType($start, ESInt::class)->unfold();
        $length = ($length === null)
            ? Type::sanitizeType(strlen($replacement), ESInt::class)->unfold()
            : Type::sanitizeType($length, ESInt::class)->unfold();
        $string = substr_replace($this->main(), $replacement, $start, $length);
        return Shoop::string($string);
    }

    public function trim($fromStart = true, $fromEnd = true, $charMask = " \t\n\r\0\x0B"): ESString
    {
        $fromStart = Type::sanitizeType($fromStart, ESBool::class)->unfold();
        $fromEnd = Type::sanitizeType($fromEnd, ESBool::class)->unfold();
        $charMask = Type::sanitizeType($charMask, ESString::class)->unfold();

        $string = $this->stringUnfolded();
        $trimmed = $string;
        if ($fromStart and $fromEnd) {
            $trimmed = trim($string, $charMask);

        } elseif ($fromStart and ! $fromEnd) {
            $trimmed = ltrim($string, $charMask);

        } elseif (! $fromStart and $fromEnd) {
            $trimmed = rtrim($string, $charMask);

        }
        return Shoop::string($trimmed);
    }

    public function lowerFirst(): ESString
    {
        $string = $this->stringUnfolded();
        $string = lcfirst($string);
        return Shoop::string($string);
    }

    public function uppercase(): ESString
    {
        $string = $this->stringUnfolded();
        $string = strtoupper($string);
        return Shoop::string($string);
    }

    public function urlencode()
    {
        $string = $this->stringUnfolded();
        $string = urlencode($string);
        return Shoop::string($string);
    }

    public function urldecode()
    {
        $string = $this->stringUnfolded();
        $string = urldecode($string);
        return Shoop::string($string);
    }

    /**
     * @deprecated PHP Shoop Extras
     */
    public function isFile(\Closure $closure = null)
    {
        $value = $this->main();
        $bool = is_file($value);
        if ($closure === null) {
            $closure = function($bool) {
                return Shoop::this($bool);
            };
        }
        return $closure($bool, Shoop::this($value));
    }

    /**
     * @deprecated PHP Shoop Extras
     */
    public function isFolder($value='')
    {
        return is_dir($this->main());
    }

    /**
     * @deprecated PHP Shoop Extras
     */
    public function pathContent($trim = true)
    {
        $path = $this->stringUnfolded();
        if (file_exists($path) and is_file($path)) {
            $contents = file_get_contents($path);
            if (strlen($contents) > 0) {
                if ($trim) {
                    return Shoop::string($contents)->trim();
                }
                return Shoop::string($contents);
            }

        } elseif (is_dir($path)) {
            $array = Shoop::array(scandir($path))->each(function($item) use ($path, $trim) {
                if ($trim and ($item === "." or $item === ".." or $item === ".DS_Store")) {
                    return Shoop::string("");
                }
                return Shoop::string($path ."/{$item}");
            })->noEmpties();
            $array = array_values($array->unfold());
            return Shoop::array($array);
        }
        return Shoop::string("");
    }

    /**
     * @deprecated PHP Shoop Extras
     */
    public function writeToPath($path, $makeFolder = true)
    {
        $string = $this->stringUnfolded();

        $path = Type::sanitizeType($path, ESString::class)->unfold();
        $makeFolder = Type::sanitizeType($makeFolder, ESBool::class)->unfold();

        $bytesOrFalse = file_put_contents($path, $string);
        return (is_bool($bytesOrFalse))
            ? Shoop::bool($bytesOrFalse)
            : Shoop::int($bytesOrFalse);
    }
}
