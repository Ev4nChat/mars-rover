<?php

namespace Tests;

use App\Plateau;
use PHPUnit\Framework\TestCase;

class PlateauTest extends TestCase
{
    public function testPlateau(): void
    {
        $plateau = new Plateau(5, 5);

        $this->assertTrue($plateau->isWithinLimits(0, 0));
        $this->assertTrue($plateau->isWithinLimits(0, 5));
        $this->assertTrue($plateau->isWithinLimits(5, 0));
        $this->assertTrue($plateau->isWithinLimits(5, 5));
        $this->assertTrue($plateau->isWithinLimits(1, 1));
        $this->assertFalse($plateau->isWithinLimits(1, 6));
    }
}