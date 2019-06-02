<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;

class DictTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = Shoop::dictionary("key", "value");
        $this->assertNotNull($result);

        $this->assertEquals("value", $result["key"]);
    }

    public function testCanIterateDictionary()
    {
        $dict = Shoop::dictionary("key", "value", "key2", "value2");
        $this->assertEquals(["key" => "value", "key2" => "value2"], $dict->unwrap());
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
        $result = Shoop::dictionary("key", "value")
            ->hasKey("key");
        $this->assertTrue($result->unwrap());
    }
}
