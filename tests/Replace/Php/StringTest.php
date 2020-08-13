<?php

namespace Eightfold\Shoop\Tests\Replace\Php;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Php;

class StringTest extends TestCase
{
    public function test_transformations()
    {
        $expected = "8fold";
        $actual = Php::stringAfterReplacing("Eightfold", ["Eight" => "8"]);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "8fold";
        $actual = Php::stringAppendedWith("8", "fold");
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "88888888";
        $actual = Php::stringRepeated("8", 8);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "eightfold";
        $actual = Php::stringToLowercaseFirst("Eightfold");
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "8fold";
        $actual = Php::stringToLowercase("8FOLD");
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = "8FOLD";
        $actual = Php::stringToUppercase("8fold");
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_splits()
    {
        $expected = ["", "8", "f", "o", "l", "d", ""];
        $actual = Php::stringSplitOn(":8:f:o:l:d:", ":");
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = ["8", "f", "o", "l", "d"];
        $actual = Php::stringSplitOn(":8:f:o:l:d:", ":", false);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_strippers()
    {
        $expected = "8fold";
        $actual = Php::stringStrippedOfLast("8fold!");
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
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
        $this->assertEqualsWithPerformance($expected, $actual, 1.5);

        // TODO: verify - this seems like it should have failed
        $this->start = hrtime(true);
        $expected = false;
        $actual = Php::stringEndsWith("8fold", "old!");
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
