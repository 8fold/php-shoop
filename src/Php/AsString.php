<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class AsString extends Filter
{
    private $glue = "";

    public function __construct(string $glue = "")
    {
        $this->glue = $glue;
    }

    public function __invoke($payload): string
    {
        if (is_bool($payload)) {
            return ($payload) ? "true" : "false";

        } elseif (is_int($payload)) {
            return strval($payload);

        } elseif (is_object($payload)) {
var_dump(__FILE__);
var_dump(__LINE__);
var_dump($payload);
die("object");
        if (method_exists($payload, "__toString")) {
            return (string) $payload;
        }

        return Shoop::pipe($payload,
            AsDictionary::apply($payload),
            AsString::apply($array)
        )->unfold();

        } elseif (is_array($payload)) {
            $strings = Shoop::pipe($payload, StripArray::applyWith("is_string"))
                ->unfold();
            return implode($strings, $this->glue);

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            if ($isJson) {
var_dump(__FILE__);
var_dump(__LINE__);
var_dump($payload);
                // return Shoop::pipe($payload, ToArrayFromJson::apply())
                    // ->unfold();
            }
            return $payload;
        }
var_dump(__FILE__);
var_dump($payload);
        return "";
    }
}
