<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class AsJson extends Filter
{
    public function __invoke($using): string
    {
        if (is_bool($using)) {
            return Shoop::pipe($using,
                AsDictionary::apply(),
                AsObject::apply(),
                AsJson::apply()
            )->unfold();

        } elseif (is_int($using)) {
            return Shoop::pipe($using,
                AsDictionary::apply(),
                AsObject::apply(),
                AsJson::apply()
            )->unfold();

        } elseif (is_object($using)) {
            return json_encode($using);

        } elseif (is_array($using)) {
            return Shoop::pipe($using,
                AsObject::apply(),
                AsJson::apply()
            )->unfold();

        } elseif (is_string($using)) {
            $isJson = Shoop::pipe($using, StringIsJson::apply())->unfold();
            if ($isJson) {
                return Shoop::pipe($using,
                    AsArray::apply(),
                    AsInteger::apply(),
                    IsNot::applyWith(0)
                )->unfold();
            }
            return Shoop::pipe($using, AsArray::apply())->unfold();
        }
        var_dump(__FILE__);
        die(var_dump($using));
        // return [];
    }
}
