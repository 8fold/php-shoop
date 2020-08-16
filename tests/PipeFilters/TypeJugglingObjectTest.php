<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters\AsTuple;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\AsInteger;
use Eightfold\Shoop\PipeFilters\AsNumber;
use Eightfold\Shoop\PipeFilters\AsBoolean;

/**
 * @group ObjectTypeJuggling
 */
class TypeJugglingObjectTest extends TestCase
{
    private function sut()
    {
        return new class {
            public $public = "content";

            public $publicEmptyString = "";

            private $private = "default";

            public $null;

            public $null2 = null;

            public function method(): void
            {}

            private function privateMethod(): void
            {}
        };
    }

    /**
     * @test
     */
    public function juggle_to_all_types_using_defaults()
    {
        $object = $this->sut();

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->public = "content";
        $expected->publicEmptyString = "";

        $tuple = AsTuple::apply()->unfoldUsing($object);
        $this->assertEqualsWithPerformance($expected, $tuple, 4.1);

        $propertyCount = count(get_object_vars($tuple));
        $this->assertTrue($propertyCount === 2,
            "Tuple contains {$propertyCount} properties");

        $this->start = hrtime(true);
        $expected = ["public" => "content", "publicEmptyString" => ""];

        $dictionary = AsDictionary::apply()->unfoldUsing($object);
        $this->assertEqualsWithPerformance($expected, $dictionary, 4.15);

        $this->start = hrtime(true);
        $expected = ["content", ""];

        $array = AsArray::apply()->unfoldUsing($object);
        $this->assertEqualsWithPerformance($expected, $array, 1.55);

        $this->start = hrtime(true);
        $expected = 2;

        $integer = AsInteger::apply()->unfoldUsing($object);
        $this->assertEqualsWithPerformance($expected, $integer, 1.75);

        $this->start = hrtime(true);
        $expected = (float) 2;

        $number = AsNumber::apply()->unfoldUsing($object);
        $this->assertEqualsWithPerformance($expected, $number, 1.5);

        $this->start = hrtime(true);
        $expected = (bool) 2;

        $bool = AsBoolean::apply()->unfoldUsing($object);
        $this->assertEqualsWithPerformance($expected, $bool, 1.1);
    }
}