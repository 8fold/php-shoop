<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\PipeFilters\DropRange;

/**
 * @group Drop
 */
class DropTest extends TestCase
{
    /**
     * @test
     */
    public function string()
    {
        $this->assertFalse(true);
    }
}
