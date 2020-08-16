<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters\AsTuple;
use Eightfold\Shoop\PipeFilters\AsJson;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\AsInteger;
use Eightfold\Shoop\PipeFilters\AsNumber;
use Eightfold\Shoop\PipeFilters\AsBoolean;

/**
 * @group StringTypeJuggling
 */
class TypeJugglingStringTest extends TestCase
{
    private function sut()
    {
        return "8fold";
    }

    /**
     * @test
     */
    public function juggle_to_all_types_using_defaults()
    {
        $string = $this->sut();

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->content = "8fold";

        $tuple = AsTuple::apply()->unfoldUsing($string);
        $this->assertEqualsWithPerformance($expected, $tuple, 1.05);

        $propertyCount = count(get_object_vars($tuple));
        $this->assertTrue($propertyCount === 1,
            "Tuple contains {$propertyCount} properties");

        $this->start = hrtime(true);
        $expected = ["content" => "8fold"];

        $dictionary = AsDictionary::apply()->unfoldUsing($string);
        $this->assertEqualsWithPerformance($expected, $dictionary, 0.9);

        $this->start = hrtime(true);
        $expected = ["8", "f", "o", "l", "d"];

        $array = AsArray::apply()->unfoldUsing($string);
        $this->assertEqualsWithPerformance($expected, $array);

        $this->start = hrtime(true);
        $expected = 5;

        $integer = AsInteger::apply()->unfoldUsing($string);
        $this->assertEqualsWithPerformance($expected, $integer);

        $this->start = hrtime(true);
        $expected = (float) 5;

        $number = AsNumber::apply()->unfoldUsing($string);
        $this->assertEqualsWithPerformance($expected, $number);

        $this->start = hrtime(true);
        $expected = (bool) 2;

        $bool = AsBoolean::apply()->unfoldUsing($string);
        $this->assertEqualsWithPerformance($expected, $bool);

        $expected = '{"content":"8fold"}';

        $json = AsJson::apply()->unfoldUsing($string);
        $this->assertEqualsWithPerformance($expected, $json);
    }
}
