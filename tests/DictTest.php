<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\ESDictionary;
use Eightfold\Shoop\ESArray;

class DictTest extends TestCase
{
    public function testCanInitializeDict()
    {
        $result = Shoop::dictionary(["key" => "value"]);
        $this->assertNotNull($result);

        $this->assertEquals("value", $result["key"]);
    }

    public function testCanIterateDictionary()
    {
        $dict = Shoop::dictionary(["key" => "value", "key2" => "value2"]);
        $this->assertEquals(["key" => "value", "key2" => "value2"], $dict->unfold());
        $count = 1;
        foreach($dict as $key => $value) {
            if ($key === "key") {
                $this->assertEquals("value", $value);

            } elseif ($key === "key2") {
                $this->assertEquals("value2", $value);

            }
            $count++;
        }
        $this->assertTrue($count > 1);
    }

    public function testCanCheckForKey()
    {
        $result = Shoop::dictionary(["key" => "value"])
            ->hasKey("key");
        $this->assertTrue($result->unfold());
    }
}