<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsObject;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsTuple;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsList;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsDictionary;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsArray;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsFloat;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsInteger;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsBoolean;

use Eightfold\Shoop\PipeFilters\TypeAs;

/**
 * @group TypeAs
 */
class TypeAsTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        $using = true;

        $this->start = hrtime(true);
        $expected = true;

        $actual = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.95);

        $using = false;

        $this->start = hrtime(true);
        $expected = 0;

        $actual = TypeAs::applyWith("integer")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = true;

        $expected = 1.0;

        $actual = TypeAs::applyWith("float")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = true;

        $expected = [true];

        $actual = TypeAs::applyWith("array")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = false;

        $expected = ["true" => false, "false" => true];

        $actual = TypeAs::applyWith("dictionary")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = true;

        $expected = (object) ["true" => true, "false" => false];

        $actual = TypeAs::applyWith("tuple")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = false;

        $this->start = hrtime(true);
        $expected = '{"true":false,"false":true}';

        $actual = TypeAs::applyWith("json")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function numbers()
    {
        $using = 1;

        $this->start = hrtime(true);
        $expected = true;

        $actual = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.1);

        $using = 1.0;

        $this->start = hrtime(true);
        $expected = 1;

        $actual = TypeAs::applyWith("integer")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.95);

        $using = 1.0;

        $this->start = hrtime(true);
        $expected = 1.0;

        $actual = TypeAs::applyWith("float")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = 1;

        $this->start = hrtime(true);
        $expected = [0, 1];

        $actual = TypeAs::applyWith("array")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = [1];

        $actual = TypeAs::applyWith("array", 1)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = 1.1;

        $expected = ["i0" => 0, "i1" => 1];

        $actual = TypeAs::applyWith("dictionary")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = (object) ["i0" => 0, "i1" => 1];

        $actual = TypeAs::applyWith("tuple")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = '{"i0":0,"i1":1}';

        $actual = TypeAs::applyWith("json")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function strings()
    {
        $using = "8fold!";

        $expected = ["8", "f", "o", "l", "d", "!"];

        $actual = TypeAs::applyWith("array")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.1);

        $this->start = hrtime(true);
        $expected = ["8", "old!"];

        $actual = TypeAs::applyWith("array", "f", false, 2)
            ->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.3);

        $using = "!8!f!o!l!d!";

        $this->start = hrtime(true);
        $expected = ["", "8", "f", "o", "l", "d", ""];

        $actual = TypeAs::applyWith("array", "!", true)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "8fold!";

        $expected = true;

        $actual = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "";

        $expected = false;

        $actual = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "8fold!";

        $expected = 6;

        $actual = TypeAs::applyWith("integer")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "";

        $expected = 0;

        $actual = TypeAs::applyWith("integer")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "8!8!8";

        $expected = ["i0" => "8", "i1" => "8!8"];

        $actual = TypeAs::applyWith("dictionary", "!", false, 2)
            ->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = (object) ["i0" => 8, "i1" => "8!8"];

        $actual = TypeAs::applyWith("tuple", "!", false, 2)
            ->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = '{"efs0":"8","efs1":"8!8"}';

        $actual = TypeAs::applyWith("json", "!", false, 2, "efs")
            ->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = ["8", "f", "o", "l", "d", "!"];

        $expected = "8fold!";

        $actual = TypeAs::applyWith("string")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function collections()
    {
        $using = [];

        $expected = false;

        $actual = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.45);

        $using = [0, 1, 2];

        $this->start = hrtime(true);
        $expected = 3;

        $actual = TypeAs::applyWith("integer")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = ["a" => 1, "b" => 2, "c" => 3];

        $expected = 3.0;

        $actual = TypeAs::applyWith("float")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = [1, 2, 3];

        $actual = TypeAs::applyWith("array")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["a" => 1, "b" => 2, "c" => 3];

        $actual = TypeAs::applyWith("dictionary")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = (object) $using;

        $actual = TypeAs::applyWith("tuple")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    // TODO: Tuple
    // TODO: JSON

    /**
     * @test
     *
     * Only does downcasting, really.
     */
    public function objects()
    {
        $using = new class {
            public $public = "content";
            private $private = "private";
            public function someAction()
            {
                return false;
            }
        };

        $this->start = hrtime(true);
        $expected = (object) ["public" => "content"];

        $actual = TypeAs::applyWith("tuple")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.9);

        $this->start = hrtime(true);
        $expected = ["public" => "content"];

        $actual = TypeAs::applyWith("dictionary")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["content"];

        $actual = TypeAs::applyWith("array")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = 1.0;

        $actual = TypeAs::applyWith("float")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = 1;

        $actual = TypeAs::applyWith("integer")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = true;

        $actual = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
