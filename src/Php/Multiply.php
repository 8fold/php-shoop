<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class Multipy extends Filter
{
    public function __construct(...$args)
    {
        $this->args = $args;
    }

    public function __invoke($payload)
    {
        if (is_bool($payload)) {
            // ToArrayFromBoolean
        } elseif (is_int($payload)) {
            // return Shoop::pipe($payload, ToArrayFromInteger::apply())->unfold();

        } elseif (is_object($payload)) {
            // ToArrayFromObject

        } elseif (is_array($payload)) {
            return Shoop::pipe($payload, AsString::applyWith(...$this->args))
                ->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            if ($isJson) {
                // return Shoop::pipe($payload, ToArrayFromJson::apply())
                //     ->unfold();
            }
            return str_repeat($payload, $multiplier);
        }
        return [];
    }
}
