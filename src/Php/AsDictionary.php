<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class AsDictionary extends Filter
{
    public function __invoke($payload): array
    {
        if (is_bool($payload)) {
            return ($payload === true)
                ? ["true" => true, "false" => false]
                : ["true" => false, "false" => true];

        } elseif (is_int($payload)) {
            return Shoop::pipe($payload,
                AsArray::apply(),
                AsDictionary::apply()
            )->unfold();

        } elseif (is_object($payload)) {
            return (array) $payload;

        } elseif (is_array($payload)) {
            $isNotDict = Shoop::pipe($payload,
                IsDictionary::apply(),
                Reverse::apply()
            )->unfold();
            if ($isNotDict) {
                $array = [];
                foreach ($payload as $member => $value) {
                    $member = "i". $member;
                    $array[$member] = $value;
                }
                return $array;

            }
            return $payload;

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            if ($isJson) {
                return Shoop::pipe($payload,
                    AsObject::apply(),
                    AsDictionary::apply()
                )->unfold();
            }
            return Shoop::pipe($payload, AsArray::apply())->unfold();
        }
        var_dump(__FILE__);
        die(var_dump($payload));
        // return [];
    }
}
