<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class Minus extends Filter
{
    // is string
    private $fromEnd = true;
    private $fromStart = true;
    private $charMask = " \t\n\r\0\x0B";

    public function __construct(...$args)
    {
        $this->args = $args;
    }

    public function __invoke($payload)
    {
        if (is_bool($payload)) {
            return Shoop::pipe($payload, Reverse::apply())->unfold();

        } elseif (is_int($payload)) {
            $int = Shoop::pipe($this->args, First::apply(), AsInt::apply())
                ->unfold();
            return $payload - 1;

        } elseif (is_object($payload)) {
            return Shoop::pipe($payload,
                AsDictionary::apply(),
                Minus::applyWith(...$this->args),
                AsObject::apply()
            )->unfold();

        } elseif (is_array($payload)) {
            return Shoop::pipe($payload, AsString::applyWith(...$this->args))
                ->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            if ($isJson) {
                // return Shoop::pipe($payload, ToArrayFromJson::apply())
                //     ->unfold();
            }

            $string    = $payload;
            $fromEnd   = ($this->args[0]) ? true : false;
            $fromStart = ($this->args[1]) ? true : false;
            $charMask  = $this->args[2];
var_dump($fromEnd);
var_dump($fromStart);
var_dump($charMask);
            if ($this->fromStart and $this->fromEnd) {
                die("true:true");
                return trim($payload, $charMask);

            } elseif ($this->fromStart and ! $this->fromEnd) {
                die("true:false");
                return ltrim($payload, $charMask);

            } elseif (! $this->fromStart and $this->fromEnd) {
                die("false:true");
                return rtrim($payload, $charMask);

            }
die("false:false");
            $needles      = Shoop::pipe($charMask, AsArray::apply())->unfold();
            $replacements = array_fill(0, count($needles), "");
die(var_dump($needles));
            //TODO: ArrayToDictionary::applyWith($members);
            // $combined = array_combine($members, $keys);
            // TODO: MembersFromArray::apply();
            // TODO: MembersFromDictionary::apply();
            return str_replace($needles, $replacements, $payload);
        }
        return [];
    }
}