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
 * @group ArrayTypeJuggling
 */
class TypeJugglingArrayTest extends TestCase
{
    private function sut()
    {
        return [
            "content",
            ""
        ];
    }

    /**
     * @test
     */
    public function juggle_to_all_types_using_defaults()
    {
        $array = $this->sut();

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->i0 = "content";
        $expected->i1 = "";

        $tuple = AsTuple::apply()->unfoldUsing($array);
        $this->assertEqualsWithPerformance($expected, $tuple, 7.7);

        $propertyCount = count(get_object_vars($tuple));
        $this->assertTrue($propertyCount === 2,
            "Tuple contains {$propertyCount} properties");

        $this->start = hrtime(true);
        $expected = ["i0" => "content", "i1" => ""];

        $dictionary = AsDictionary::apply()->unfoldUsing($array);
        $this->assertEqualsWithPerformance($expected, $dictionary);

        $this->start = hrtime(true);
        $expected = ["content", ""];

        $array = AsArray::apply()->unfoldUsing($array);
        $this->assertEqualsWithPerformance($expected, $array, 0.9);

        $this->start = hrtime(true);
        $expected = 2;

        $integer = AsInteger::apply()->unfoldUsing($array);
        $this->assertEqualsWithPerformance($expected, $integer, 1.25);

        $this->start = hrtime(true);
        $expected = (float) 2;

        $number = AsNumber::apply()->unfoldUsing($array);
        $this->assertEqualsWithPerformance($expected, $number, 1.1);

        $this->start = hrtime(true);
        $expected = true;

        $bool = AsBoolean::apply()->unfoldUsing($array);
        $this->assertEqualsWithPerformance($expected, $bool, 1.25);

        $expected = '{"i0":"content","i1":""}';

        $json = AsJson::apply()->unfoldUsing($array);
        $this->assertEqualsWithPerformance($expected, $json, 1.5);
    }

    /**
     * @test
     */
    public function customize_prefix_for_dictionary()
    {
        $array = $this->sut();

        $this->start = hrtime(true);
        $expected = ["efs0" => "content", "efs1" => ""];

        $dictionary = AsDictionary::applyWith("efs")->unfoldUsing($array);
        $this->assertEqualsWithPerformance($expected, $dictionary, 5.15);
    }
}
