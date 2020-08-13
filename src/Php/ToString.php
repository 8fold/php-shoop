<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class ToString extends Bend
{
    private $arg = "";

    public function __construct(string $arg = "")
    {
        $this->arg = $arg;
    }

    public function __invoke($payload): string
    {
        if (is_bool($payload)) {
            return ($payload) ? "true" : "false";

        } elseif (is_int($payload)) {
            return strval($payload);

        } elseif (is_object($payload)) {
            // ToArrayFromObject

        } elseif (is_array($payload)) {
            return Shoop::pipeline($payload,
                ToStringFromArray::bendWith($this->arg)
            )->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipeline($payload, StringIsJson::bend())->unfold();
            if ($isJson) {
                // return Shoop::pipeline($payload, ToArrayFromJson::bend())
                    // ->unfold();
            }
            // return Shoop::pipeline($payload, ToArrayFromString::bend())
                // ->unfold();
        }
var_dump(__FILE__);
var_dump($payload);
        return "";
    }
}
