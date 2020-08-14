<?php

namespace Eightfold\Shoop\Tests\Replace;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Php;

use Eightfold\Shoop\ESJson;

class ESJsonTest extends TestCase
{
    public function test_type_juggling()
    {
        $json = '{"member":"8fold","member2":true}';

        $this->start = hrtime(true);
        $expected = ["8fold", true];
        $actual = ESJson::fold($json)->array()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 0.8);

        $this->start = hrtime(true);
        $expected = false;
        $actual = ESJson::fold('{}')->bool()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 1);

        $this->start = hrtime(true);
        $expected = 1;
        $actual = ESJson::fold('{"key":"value"}')->int()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = new stdClass;
        $actual = ESJson::fold('{}')->object()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2);
    }
}
