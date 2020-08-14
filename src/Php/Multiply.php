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

    public function __invoke($using)
    {
        if (is_bool($using)) {
            // ToArrayFromBoolean
        } elseif (is_int($using)) {
            // return Shoop::pipe($using, ToArrayFromInteger::apply())->unfold();

        } elseif (is_object($using)) {
            // ToArrayFromObject

        } elseif (is_array($using)) {
            return Shoop::pipe($using, AsString::applyWith(...$this->args))
                ->unfold();

        } elseif (is_string($using)) {
            $isJson = Shoop::pipe($using, StringIsJson::apply())->unfold();
            if ($isJson) {
                // return Shoop::pipe($using, ToArrayFromJson::apply())
                //     ->unfold();
            }
            return str_repeat($using, $multiplier);
        }
        return [];
    }
}
