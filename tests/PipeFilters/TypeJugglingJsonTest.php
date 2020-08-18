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

/**
 * @group JsonTypeJuggling
 */
class TypeJugglingJsonTest extends TestCase
{
    private function sut()
    {
        return '{"public": "content", "boolean": true}';
    }

    /**
     * @test
     */
    public function juggle_to_all_types_using_defaults()
    {
        $json = $this->sut();

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->public = "content";
        $expected->boolean = true;

        $tuple = AsTuple::apply()->unfoldUsing($json);
        $this->assertEqualsWithPerformance($expected, $tuple, 1);

        $propertyCount = count(get_object_vars($tuple));
        $this->assertTrue($propertyCount === 2,
            "Tuple contains {$propertyCount} properties");

        $this->start = hrtime(true);
        $expected = ["public" => "content", "boolean" => true];

        $dictionary = AsDictionary::apply()->unfoldUsing($json);
        $this->assertEqualsWithPerformance($expected, $dictionary, 1.1);

        $this->start = hrtime(true);
        $expected = ["content", true];

        $array = AsArray::apply()->unfoldUsing($json);
        $this->assertEqualsWithPerformance($expected, $array);

        $this->start = hrtime(true);
        $expected = 2;

        $integer = AsInteger::apply()->unfoldUsing($json);
        $this->assertEqualsWithPerformance($expected, $integer);

        $this->start = hrtime(true);
        $expected = (float) 2;

        $number = AsNumber::apply()->unfoldUsing($json);
        $this->assertEqualsWithPerformance($expected, $number);

        $this->start = hrtime(true);
        $expected = (bool) 2;

        $bool = AsBoolean::apply()->unfoldUsing($json);
        $this->assertEqualsWithPerformance($expected, $bool);
    }
}
