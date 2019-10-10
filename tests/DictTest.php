<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Helpers\Type;
use Eightfold\Shoop\ESDictionary;
use Eightfold\Shoop\ESArray;

use Eightfold\Shoop\Tests\TestObject;

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

    public function testCanGetValueForKey()
    {
        $assoc = [
            "one" => 1,
            "two" => [1, 2],
            "three" => (object) [
                "one" => 1,
                "two" => 2
            ],
            "four" => Shoop::array([1, 2]),
            "five" => (new TestObject)
        ];

        $dict = Shoop::dictionary($assoc);
        $this->assertEquals(
            1,
            $dict->valueForKeyUnfolded("one")
        );

        $this->assertTrue(
            is_array(
                $dict->valueForKeyUnfolded("two")
            )
        );

        $this->assertTrue(
            is_a(
                $dict->valueForKeyUnfolded("three"),
                \stdClass::class
            )
        );

        $this->assertTrue(Type::isShooped(
            // TODO: Possibly remove "Unfolded" suffix shorthand
            $dict->valueForKey("four")
        ));

        $this->assertTrue(
            is_a(
                $dict->valueForKeyUnfolded("five"),
                TestObject::class
            )
        );
    }
}
