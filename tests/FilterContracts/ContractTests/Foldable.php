<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Shooped;

trait Foldable
{
    /**
     * @test
     */
    public function fold()
    {
        $expected = false;
        $instance = Shooped::fold($expected);
        $actual   = $instance->args(true)[0];
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function unfold()
    {
        $expected = true;
        $actual   = Shooped::fold($expected)->unfold();
        $this->assertEquals($expected, $actual);
    }
}
