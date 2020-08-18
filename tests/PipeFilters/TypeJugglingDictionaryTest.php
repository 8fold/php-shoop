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
 * @group DictionaryTypeJuggling
 */
class TypeJugglingDictionaryTest extends TestCase
{
    private function sut()
    {
        return [
            "public" => "content",
            "publicEmptyString" => ""
        ];
    }

    /**
     * @test
     */
    public function juggle_to_all_types_using_defaults()
    {
        $dictionary = $this->sut();

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->public = "content";
        $expected->publicEmptyString = "";

        $tuple = AsTuple::apply()->unfoldUsing($dictionary);
        $this->assertEqualsWithPerformance($expected, $tuple, 0.85);

        $propertyCount = count(get_object_vars($tuple));
        $this->assertTrue($propertyCount === 2,
            "Tuple contains {$propertyCount} properties");

        $this->start = hrtime(true);
        $expected = ["public" => "content", "publicEmptyString" => ""];

        $dictionary = AsDictionary::apply()->unfoldUsing($dictionary);
        $this->assertEqualsWithPerformance($expected, $dictionary);

        $this->start = hrtime(true);
        $expected = ["content", ""];

        $array = AsArray::apply()->unfoldUsing($dictionary);
        $this->assertEqualsWithPerformance($expected, $array);

        $this->start = hrtime(true);
        $expected = 2;

        $integer = AsInteger::apply()->unfoldUsing($dictionary);
        $this->assertEqualsWithPerformance($expected, $integer, 0.75);

        $this->start = hrtime(true);
        $expected = (float) 2;

        $number = AsNumber::apply()->unfoldUsing($dictionary);
        $this->assertEqualsWithPerformance($expected, $number);

        $this->start = hrtime(true);
        $expected = (bool) 2;

        $bool = AsBoolean::apply()->unfoldUsing($dictionary);
        $this->assertEqualsWithPerformance($expected, $bool);

        $expected = '{"public":"content","publicEmptyString":""}';

        $json = AsJson::apply()->unfoldUsing($dictionary);
        $this->assertEqualsWithPerformance($expected, $json);
    }
}
