<?php

namespace Domain\Entity;

use PHPUnit\Framework\TestCase;

class LibraryUnitTest extends TestCase
{
    /** @test */
    public function should_one_plus_one_be_two()
    {
        $payload = [1, 1];

        $sum = array_reduce($payload, fn(int $carry, int $item) => $carry += $item, 0);

        $this->assertEquals(2, $sum);
    }
}