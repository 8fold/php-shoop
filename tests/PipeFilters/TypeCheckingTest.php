<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\PipeFilters\IsObject;
use Eightfold\Shoop\PipeFilters\IsTuple;
use Eightfold\Shoop\PipeFilters\IsList;
use Eightfold\Shoop\PipeFilters\IsDictionary;
use Eightfold\Shoop\PipeFilters\IsArray;
use Eightfold\Shoop\PipeFilters\IsNumber;
use Eightfold\Shoop\PipeFilters\IsFloat;
use Eightfold\Shoop\PipeFilters\IsInteger;
use Eightfold\Shoop\PipeFilters\IsString;
use Eightfold\Shoop\PipeFilters\IsBoolean;

/**
 * @group TypeChecking
 */
class TypeCheckingTest extends TestCase
{
    /**
     * @test
     */
    public function object()
    {
        $sut = new class {
            public $public = "content";
            private $private = "private";
            public function someAction()
            {
                return false;
            }
        };

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsObject::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual, 3.6);

        $sut = new stdClass;

        $this->start = hrtime(true);
        $expected = false;

        $actual = IsObject::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $sut = new class {
            public $public = "content";
            private $private = "private";
        };

        $this->start = hrtime(true);
        $expected = false;

        $actual = IsObject::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $sut = ["a" => 1];

        $this->start = hrtime(true);
        $expected = false;

        $actual = IsObject::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function tuple()
    {
        $sut = new stdClass;

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsTuple::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $sut = new class {
            public $public = "content";
            private $private = "private";
        };

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsTuple::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $sut = new class {
            public $public = "content";
            private $private = "private";
            public function someAction()
            {
                return false;
            }
        };

        $this->start = hrtime(true);
        $expected = false;

        $actual = IsTuple::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $sut = [0, 1, 2];

        $this->start = hrtime(true);
        $expected = false;

        $this->start = hrtime(true);
        $expected = false;

        $actual = IsTuple::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function list()
    {
        $sut = [];

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsList::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = false;

        $actual = IsDictionary::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = false;

        $actual = IsArray::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $sut = ["a" => 1, "b" => 2, "c" => 3];

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsList::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsDictionary::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $sut = array_values($sut);

        $this->start = hrtime(true);
        $expected = false;

        $actual = IsDictionary::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsArray::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual, 0.85);

        $sut = [3 => "8fold", 4 => true];

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsArray::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function numbers()
    {
        $sut = 1.0;

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsNumber::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsFloat::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsInteger::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $sut = 1.1;

        $this->start = hrtime(true);
        $expected = false;

        $actual = IsInteger::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function strings()
    {
        $sut = "Hello!";

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsString::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $sut = "{}";

        $this->start = hrtime(true);
        $expected = false;

        $actual = IsString::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsString::applyWith(true)->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function boolean()
    {
        $sut = true;

        $this->start = hrtime(true);
        $expected = true;

        $actual = IsBoolean::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */

}
