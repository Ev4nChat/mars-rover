<?php

namespace Tests;

use App\Plateau;
use App\Rover;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RoverTest extends TestCase
{
    public function testTurnLeft(): void
    {
        $plateau = new Plateau(5, 5);
        $rover = new Rover(1, 1, 'N', $plateau);
        $result = $rover->readAndProcessInstructions('L');

        $this->assertEquals('1 1 W', $result);
    }

    public function testTurnLeftInvalidOrientation(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $plateau = new Plateau(5, 5);
        $rover = new Rover(1, 1, 'X', $plateau);
        $rover->readAndProcessInstructions('L');
    }

    public function testTurnRight(): void
    {
        $plateau = new Plateau(5, 5);
        $rover = new Rover(1, 1, 'N', $plateau);
        $result = $rover->readAndProcessInstructions('R');

        $this->assertEquals('1 1 E', $result);
    }

    public function testTurnRightInvalidOrientation(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $plateau = new Plateau(5, 5);
        $rover = new Rover(1, 1, 'X', $plateau);
        $rover->readAndProcessInstructions('R');
    }

    public function testMoveNorth(): void
    {
        $plateau = new Plateau(5, 5);
        $rover = new Rover(1, 1, 'N', $plateau);
        $result = $rover->readAndProcessInstructions('M');

        $this->assertEquals('1 2 N', $result);

    }

    public function testMoveEast(): void
    {
        $plateau = new Plateau(5, 5);
        $rover = new Rover(1, 1, 'E', $plateau);
        $result = $rover->readAndProcessInstructions('M');

        $this->assertEquals('2 1 E', $result);
    }

    public function testMoveSouth(): void
    {
        $plateau = new Plateau(5, 5);
        $rover = new Rover(1, 1, 'S', $plateau);
        $result = $rover->readAndProcessInstructions('M');

        $this->assertEquals('1 0 S', $result);
    }

    public function testMoveWest(): void
    {
        $plateau = new Plateau(5, 5);
        $rover = new Rover(1, 1, 'W', $plateau);
        $result = $rover->readAndProcessInstructions('M');

        $this->assertEquals('0 1 W', $result);
    }

    public function testReadAndProcessInstructions(): void
    {
        $plateau = new Plateau(5, 5);
        $rover = new Rover(1, 1, 'N', $plateau);
        $result = $rover->readAndProcessInstructions('LMRMMM');

        $this->assertEquals('0 4 N', $result);
    }

    public function testMoveOutsideLimits(): void
    {
        $plateau = new Plateau(5, 5);
        $rover = new Rover(0, 1, 'W', $plateau);
        $result = $rover->readAndProcessInstructions('M');

        $this->assertEquals('0 1 W', $result);
    }
}
