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

use Eightfold\Shoop\PipeFilters\TypeOf;

/**
 * @group TypeChecking
 */
class TypeOfTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        $using = true;

        $this->start = hrtime(true);
        $expected = ["boolean"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = false;

        $this->start = hrtime(true);
        $expected = ["boolean"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function numbers()
    {
        $using = 1;

        $expected = ["number", "integer"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = 1.0;

        $this->start = hrtime(true);
        $expected = ["number", "integer", "float"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = 1.0;

        $expected = ["float"];

        $actual = TypeOf::applyWith(true)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = 1.1;

        $expected = ["float"];

        $actual = TypeOf::applyWith(true)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = 1.1;

        $expected = ["number", "float"];

        $actual = TypeOf::applyWith(false)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function strings()
    {
        $using = "8fold!";

        $expected = ["string"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "{}";

        $this->start = hrtime(true);
        $expected = ["string"];

        $actual = TypeOf::applyWith(true)->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "{}";

        $expected = ["collection", "tuple", "json"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "{hello}";

        $expected = ["string"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = '{"hello":true}';

        $expected = ["collection", "tuple", "json"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "{something";

        $expected = ["string"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = "somehing}";

        $expected = ["string"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function collections()
    {
        $using = [];

        $expected = ["collection", "list"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual, 1.45);

        $using = [0, 1, 2];

        $this->start = hrtime(true);
        $expected = ["collection", "list", "array"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = ["collection", "list", "array"];

        $using = [3 => "8fold", 4 => true];

        $expected = ["collection", "list", "array"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = ["a" => 1, "b" => 2, "c" => 3];

        $expected = ["collection", "list", "dictionary"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = ["a" => 1, 1 => 2, "c" => 3];

        $expected = ["collection", "list"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = new stdClass;

        $expected = ["collection", "tuple"];

        $actual = TypeOf::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $actual);

        $using = new class {
            public $public = "content";
            private $private = "private";
        };

        $expected = ["collection", "tuple"];

        $actual = TypeOf::apply()->unfoldUsing($using);
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

        $expected = ["object"];

        $actual = TypeOf::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
