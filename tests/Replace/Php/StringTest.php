<?php

namespace Eightfold\Shoop\Tests\Replace\Php;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Php;

class StringTest extends TestCase
{
    public function test_strippers()
    {
        $expected = "8fold";
        $actual = Php::stringStrippedOfTags("<p><i>8fold</i></p>");
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = "8fold";
        $actual = Php::stringStrippedOf("!8&f!o\$l)d", false, false, "!&$)");
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $doc = <<<EOD

            8fold!

        EOD;
        $expected = "8fold!";
        $actual = Php::stringStrippedOf($doc);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = <<<EOD

            8fold!
        EOD;
        $actual = Php::stringStrippedOf($doc, true, false);
        $this->assertEqualsWithPerformance($expected, $actual, 0.8);

        $this->start = hrtime(true);
        $expected = <<<EOD
        8fold!

        EOD;
        $actual = Php::stringStrippedOf($doc, false, true);
        $this->assertEqualsWithPerformance($expected, $actual, 0.8);
    }

    public function test_search()
    {
        $expected = true;
        $actual = Php::stringStartsWith("8fold", "8");
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = false;
        $actual = Php::stringStartsWith("8fold", "old");
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_reverse()
    {
        $expected = "8fold";
        $actual = Php::stringReversed("dlof8");
        $this->assertEqualsWithPerformance($expected, $actual, 1);
    }

    public function test_to_array()
    {
        $expected = ["8", "f", "o", "l", "d"];
        $actual = Php::stringToArray("8fold");
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}