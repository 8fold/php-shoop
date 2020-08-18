<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsTuple;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsDictionary;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsBoolean;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsJson;

/**
 * @group TupleTypeJuggling
 */
class TypeJugglingTupleTest extends TestCase
{
    private function sut()
    {
        $tuple = new stdClass;
        $tuple->public = "content";
        $tuple->publicEmptyString = "";
        return $tuple;
    }

    /**
     * @test
     */
    public function juggle_to_all_types_using_defaults()
    {
        $tuple = $this->sut();

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->public = "content";
        $expected->publicEmptyString = "";

        $tuple = AsTuple::apply()->unfoldUsing($tuple);
        $this->assertEqualsWithPerformance($expected, $tuple, 2.85);

        $propertyCount = count(get_object_vars($tuple));
        $this->assertTrue($propertyCount === 2,
            "Tuple contains {$propertyCount} properties");

        $this->start = hrtime(true);
        $expected = ["public" => "content", "publicEmptyString" => ""];

        $dictionary = AsDictionary::apply()->unfoldUsing($tuple);
        $this->assertEqualsWithPerformance($expected, $dictionary, 2.15);

        $this->start = hrtime(true);
        $expected = ["content", ""];

        $array = AsArray::apply()->unfoldUsing($tuple);
        $this->assertEqualsWithPerformance($expected, $array, 5.6);

        $this->start = hrtime(true);
        $expected = 2;

        $integer = AsInteger::apply()->unfoldUsing($tuple);
        $this->assertEqualsWithPerformance($expected, $integer, 1);

        $this->start = hrtime(true);
        $expected = (float) 2;

        $number = AsNumber::apply()->unfoldUsing($tuple);
        $this->assertEqualsWithPerformance($expected, $number, 0.9);

        $this->start = hrtime(true);
        $expected = (bool) 2;

        $bool = AsBoolean::apply()->unfoldUsing($tuple);
        $this->assertEqualsWithPerformance($expected, $bool);

        $expected = '{"public":"content","publicEmptyString":""}';

        $json = AsJson::apply()->unfoldUsing($tuple);
        $this->assertEqualsWithPerformance($expected, $json);
    }
}
