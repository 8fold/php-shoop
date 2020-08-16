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
 * @group BooleanTypeJuggling
 */
class TypeJugglingBooleanTest extends TestCase
{
    private function sutTrue()
    {
        return true;
    }

    /**
     * @test
     */
    public function juggle_to_all_types_using_defaults()
    {
        $bool = $this->sutTrue();

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->true = true;
        $expected->false = false;

        $tuple = AsTuple::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $tuple, 1.95);

        $propertyCount = count(get_object_vars($tuple));
        $this->assertTrue($propertyCount === 2,
            "Tuple contains {$propertyCount} properties");

        $this->start = hrtime(true);
        $expected = ["true" => true, "false" => false];

        $dictionary = AsDictionary::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $dictionary);

        $this->start = hrtime(true);
        $expected = [true];

        $array = AsArray::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $array);

        $this->start = hrtime(true);
        $expected = 1;

        $integer = AsInteger::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $integer);

        $this->start = hrtime(true);
        $expected = (float) 1;

        $number = AsNumber::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $number);

        $this->start = hrtime(true);
        $expected = (bool) true;

        $bool = AsBoolean::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $bool);

        $expected = '{"true":true,"false":false}';

        $json = AsJson::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $json);
    }

    private function sutFalse()
    {
        return false;
    }

    /**
     * @test
     */
    public function juggle_to_all_types_using_defaults_false()
    {
        $bool = $this->sutFalse();

        $this->start = hrtime(true);
        $expected = new stdClass;
        $expected->true = false;
        $expected->false = true;

        $tuple = AsTuple::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $tuple);

        $propertyCount = count(get_object_vars($tuple));
        $this->assertTrue($propertyCount === 2,
            "Tuple contains {$propertyCount} properties");

        $this->start = hrtime(true);
        $expected = ["true" => false, "false" => true];

        $dictionary = AsDictionary::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $dictionary);

        $this->start = hrtime(true);
        $expected = [false];

        $array = AsArray::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $array);

        $this->start = hrtime(true);
        $expected = 0;

        $integer = AsInteger::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $integer);

        $this->start = hrtime(true);
        $expected = (float) 0;

        $number = AsNumber::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $number);

        $this->start = hrtime(true);
        $expected = (bool) false;

        $bool = AsBoolean::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $bool);

        $expected = '{"true":false,"false":true}';

        $json = AsJson::apply()->unfoldUsing($bool);
        $this->assertEqualsWithPerformance($expected, $json);
    }
}
