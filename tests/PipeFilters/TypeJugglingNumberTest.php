<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsTuple;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsJson;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsDictionary;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsBoolean;

/**
 * @group NumberTypeJuggling
 */
class TypeJugglingNumerTest extends TestCase
{
    private function sut()
    {
        return (float) 2;
    }

    /**
     * @test
     */
    public function juggle_to_all_types_using_defaults()
    {
        $number = $this->sut();

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->i0 = 0;
        $expected->i1 = 1;
        $expected->i2 = 2;

        $tuple = AsTuple::apply()->unfoldUsing($number);
        $this->assertEqualsWithPerformance($expected, $tuple, 8.3);

        $propertyCount = count(get_object_vars($tuple));
        $this->assertTrue($propertyCount === 3,
            "Tuple contains {$propertyCount} properties");

        $this->start = hrtime(true);
        $expected = ["i0" => 0, "i1" => 1, "i2" => 2];

        $dictionary = AsDictionary::apply()->unfoldUsing($number);
        $this->assertEqualsWithPerformance($expected, $dictionary);

        $this->start = hrtime(true);
        $expected = [0, 1, 2];

        $array = AsArray::apply()->unfoldUsing($number);
        $this->assertEqualsWithPerformance($expected, $array);

        $this->start = hrtime(true);
        $expected = 2;

        $integer = AsInteger::apply()->unfoldUsing($number);
        $this->assertEqualsWithPerformance($expected, $integer);

        $this->start = hrtime(true);
        $expected = (float) 2;

        $number = AsNumber::apply()->unfoldUsing($number);
        $this->assertEqualsWithPerformance($expected, $number, 0.9);

        $this->start = hrtime(true);
        $expected = (bool) 2;

        $bool = AsBoolean::apply()->unfoldUsing($number);
        $this->assertEqualsWithPerformance($expected, $bool);

        $expected = '{"i0":0,"i1":1,"i2":2}';

        $json = AsJson::apply()->unfoldUsing($number);
        $this->assertEqualsWithPerformance($expected, $json);
    }
}
