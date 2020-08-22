<?php

namespace Eightfold\Shoop\Tests\Order;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Type;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInteger,
    ESJson,
    ESTuple,
    ESString
};

/**
 * The `sort()` method sorts the array representation of the `Shoop type`. It accepts two arguments, the first argument specifies whether to sort ascending or descending (ascending is the default), the second argument specifies whether to sort the valuea or members (values is the default).
 */
class SortMembersTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray
     */
    public function ESArray()
    {
        $expected = [
            "beta",
            "Alpha",
            "gamma",
            "Beta",
            "alpha",
            "Gamma"
        ];
        $actual = Shoop::array([
            "beta",
            "Alpha",
            "gamma",
            "Beta",
            "alpha" ,
            "Gamma"
        ])->sortMembers();
        $this->assertSame($expected, $actual->unfold());

        krsort($expected);
        // $expected = [
        //     "gamma",
        //     "beta",
        //     "alpha",
        //     "Gamma",
        //     "Beta",
        //     "Alpha"
        // ];

        $actual = Shoop::array([
            "beta",
            "Alpha",
            "gamma",
            "Beta",
            "alpha" ,
            "Gamma"
        ])->sortMembers(false);
        $this->assertSame($expected, $actual->unfold());
    }

    /**
     * @not Could be a random boolean generator
     */
    public function ESBoolean()
    {
        $this->assertFalse(false);
    }

    /**
     * @return Eightfold\Shoop\ESDictionary
     */
    public function ESDictionary()
    {
        $expected = [
            "alpha" => "beta",
            "beta"  => "Beta",
            "delta" => "alpha",
            "gamma" => "Alpha"
        ];
        $actual = Shoop::dictionary([
            "gamma" => "Alpha",
            "beta"  => "Beta",
            "delta" => "alpha",
            "alpha" => "beta"
        ])->sortMembers();
        $this->assertSame($expected, $actual->unfold());

        krsort($expected);
        $actual = Shoop::dictionary(["gamma" => "Alpha", "beta" => "Beta", "delta" => "alpha", "alpha" => "beta"])->sortMembers(false);
        $this->assertSame($expected, $actual->unfold());
    }

    /**
     * @not Could sort the range
     */
    public function ESInteger()
    {
        $this->assertFalse(false);
    }

    /**
     * @see ESTuple->sort()
     *
     * @return Eightfold\Shoop\ESJson After converting the JSON string to an ESTuple.
     */
    public function ESJson()
    {
        $baseExpected = [
            "alpha" => "beta",
            "beta" => "Beta",
            "delta" => "alpha",
            "gamma" => "Alpha"
        ];
        $expected = json_encode($baseExpected);
        $actual = Shoop::json('{"gamma":"Alpha","beta":"Beta","delta":"alpha","alpha":"beta"}')->sortMembers();
        $this->assertEquals($expected, $actual->unfold());

        $baseExpected = [
            "gamma" => "Alpha",
            "delta" => "alpha",
            "beta" => "Beta",
            "alpha" => "beta"
        ];
        $expected = json_encode($baseExpected);
        $actual = Shoop::json('{"gamma":"Alpha","beta":"Beta","delta":"alpha","alpha":"beta"}')->sortMembers(false);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESTuple
     */
    public function ESTuple()
    {
        $expected = (object) [
            "alpha" => "beta",
            "beta" => "Beta",
            "delta" => "alpha",
            "gamma" => "Alpha"
        ];
        $object = new \stdClass();
        $object->gamma = "Alpha";
        $object->beta = "Beta";
        $object->delta = "alpha";
        $object->alpha = "beta";
        $actual = Shoop::object($object)->sortMembers();
        $this->assertEquals($expected, $actual->unfold());

        $expected = (object) [
            "gamma" => "Alpha",
            "delta" => "alpha",
            "beta" => "Beta",
            "alpha" => "beta"
        ];
        $object = new \stdClass();
        $object->gamma = "Alpha";
        $object->beta = "Beta";
        $object->delta = "alpha";
        $object->alpha = "beta";
        $actual = Shoop::object($object)->sortMembers(false);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\FluentTypes\ESString After sorting the individual characters of the original string.
     */
    public function ESString()
    {
        $expected = "alpha";
        $actual = Shoop::string("alpha")->sortMembers();
        $this->assertEquals($expected, $actual->unfold());
    }
}
