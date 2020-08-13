<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class AsJson extends Filter
{
    public function __invoke($payload): string
    {
        if (is_bool($payload)) {
            return Shoop::pipe($payload,
                AsDictionary::apply(),
                AsObject::apply(),
                AsJson::apply()
            )->unfold();

        } elseif (is_int($payload)) {
            return Shoop::pipe($payload,
                AsDictionary::apply(),
                AsObject::apply(),
                AsJson::apply()
            )->unfold();

        } elseif (is_object($payload)) {
            return json_encode($payload);

        } elseif (is_array($payload)) {
            return Shoop::pipe($payload,
                AsObject::apply(),
                AsJson::apply()
            )->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            if ($isJson) {
                return Shoop::pipe($payload,
                    AsArray::apply(),
                    AsInteger::apply(),
                    IsNot::applyWith(0)
                )->unfold();
            }
            return Shoop::pipe($payload, AsArray::apply())->unfold();
        }
        var_dump(__FILE__);
        die(var_dump($payload));
        // return [];
    }
}
