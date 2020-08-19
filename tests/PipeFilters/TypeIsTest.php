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

use Eightfold\Shoop\PipeFilters\TypeIs;

/**
 * @group TypeChecking
 *
 * @group  TypeIs
 */
class TypeIsTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        $using = true;

        $this->start = hrtime(true);
        $expected = true;

        $actual = TypeIs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 0.75);

        $using = false;

        $this->start = hrtime(true);
        $expected = true;

        $actual = TypeIs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function numbers()
    {
        $using = 1;

        $expected = true;

        $actual = TypeIs::applyWith("number")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = TypeIs::applyWith("integer")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = 1.0;

        $this->start = hrtime(true);
        $expected = true;

        $actual = TypeIs::applyWith("float")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = 1.0;

        $expected = true;

        $actual = TypeIs::applyWith("float", true)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function strings()
    {
        $using = "";

        $this->start = hrtime(true);
        $expected = true;

        $actual = TypeIs::applyWith("string")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "8fold!";

        $this->start = hrtime(true);
        $expected = true;

        $actual = TypeIs::applyWith("string")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "{}";

        $expected = true;

        $actual = TypeIs::applyWith("string", true)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "{}";

        $expected = true;

        $actual = TypeIs::applyWith("json")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = TypeIs::applyWith("tuple")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = TypeIs::applyWith("collection")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "{hello}";

        $expected = true;

        $actual = TypeIs::applyWith("string")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = '{"hello":true}';

        $expected = true;

        $actual = TypeIs::applyWith("json")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "{something";

        $expected = true;

        $actual = TypeIs::applyWith("string")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "somehing}";

        $expected = true;

        $actual = TypeIs::applyWith("string")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function collections()
    {
        $using = [];

        $expected = true;

        $actual = TypeIs::applyWith("collection")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.45);

        $actual = TypeIs::applyWith("list")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.45);

        $using = [0, 1, 2];

        $this->start = hrtime(true);
        $expected = true;

        $actual = TypeIs::applyWith("array")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = true;

        $actual = TypeIs::applyWith("list")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = [3 => "8fold", 4 => true];

        $actual = TypeIs::applyWith("array")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["collection", "list", "array"];

        $using = ["a" => 1, "b" => 2, "c" => 3];

        $expected = true;

        $actual = TypeIs::applyWith("dictionary")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = ["a" => 1, 1 => 2, "c" => 3];

        $expected = false;

        $actual = TypeIs::applyWith("dictionary")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = TypeIs::applyWith("array")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = true;

        $actual = TypeIs::applyWith("collection")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $actual = TypeIs::applyWith("list")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = new stdClass;

        $expected = true;

        $actual = TypeIs::applyWith("tuple")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = new class {
            public $public = "content";
            private $private = "private";
        };

        $expected = true;

        $actual = TypeIs::applyWith("collection")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function objects()
    {
        $sut = new class {
            public $public = "content";
            private $private = "private";
            public function someAction()
            {
                return false;
            }
        };

        $expected = true;

        $actual = TypeIs::applyWith("object")->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
