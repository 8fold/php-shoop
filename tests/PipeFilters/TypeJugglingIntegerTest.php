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
 * @group IntegerTypeJuggling
 */
class TypeJugglingIntegerTest extends TestCase
{
    private function sut()
    {
        return 2;
    }

    /**
     * @test
     */
    public function juggle_to_all_types_using_defaults()
    {
        $integer = $this->sut();

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->i0 = 0;
        $expected->i1 = 1;
        $expected->i2 = 2;

        $tuple = AsTuple::apply()->unfoldUsing($integer);
        $this->assertEqualsWithPerformance($expected, $tuple, 6.3);

        $propertyCount = count(get_object_vars($tuple));
        $this->assertTrue($propertyCount === 3,
            "Tuple contains {$propertyCount} properties");

        $this->start = hrtime(true);
        $expected = ["i0" => 0, "i1" => 1, "i2" => 2];

        $dictionary = AsDictionary::apply()->unfoldUsing($integer);
        $this->assertEqualsWithPerformance($expected, $dictionary);

        $this->start = hrtime(true);
        $expected = [0, 1, 2];

        $array = AsArray::apply()->unfoldUsing($integer);
        $this->assertEqualsWithPerformance($expected, $array);

        $this->start = hrtime(true);
        $expected = 2;

        $integer = AsInteger::apply()->unfoldUsing($integer);
        $this->assertEqualsWithPerformance($expected, $integer, 1.35);

        $this->start = hrtime(true);
        $expected = (float) 2;

        $number = AsNumber::apply()->unfoldUsing($integer);
        $this->assertEqualsWithPerformance($expected, $number, 0.75);

        $this->start = hrtime(true);
        $expected = (bool) 2;

        $bool = AsBoolean::apply()->unfoldUsing($integer);
        $this->assertEqualsWithPerformance($expected, $bool, 1.15);
    }
}
