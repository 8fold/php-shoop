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

    public function __invoke($using)
    {
        if (is_bool($using)) {
            return Shoop::pipe($using, Reverse::apply())->unfold();

        } elseif (is_int($using)) {
            $int = Shoop::pipe($this->args, PullFirst::apply(), AsInteger::apply())
                ->unfold();
            return $using - 1;

        } elseif (is_object($using)) {
            return Shoop::pipe($using,
                AsDictionary::apply(),
                Minus::applyWith(...$this->args),
                AsObject::apply()
            )->unfold();

        } elseif (is_array($using)) {
            return Shoop::pipe($using, AsString::applyWith(...$this->args))
                ->unfold();

        } elseif (is_string($using)) {
            $isJson = Shoop::pipe($using, StringIsJson::apply())->unfold();
            if ($isJson) {
                // return Shoop::pipe($using, ToArrayFromJson::apply())
                //     ->unfold();
            }

            $string    = $using;
            $fromEnd   = ($this->args[0]) ? true : false;
            $fromStart = ($this->args[1]) ? true : false;
            $charMask  = $this->args[2];
            if ($this->fromStart and $this->fromEnd) {
                return trim($using, $charMask);

            } elseif ($this->fromStart and ! $this->fromEnd) {
                return ltrim($using, $charMask);

            } elseif (! $this->fromStart and $this->fromEnd) {
                return rtrim($using, $charMask);

            }

            $needles      = Shoop::pipe($charMask, AsArray::apply())->unfold();
            $replacements = array_fill(0, count($needles), "");
die(var_dump($needles));
            //TODO: ArrayToDictionary::applyWith($members);
            // $combined = array_combine($members, $keys);
            // TODO: MembersFromArray::apply();
            // TODO: MembersFromDictionary::apply();
            return str_replace($needles, $replacements, $using);
        }
        return [];
    }
}
