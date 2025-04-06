<?php

namespace App;

use InvalidArgumentException;

class Rover
{
    private int $x;
    private int $y;
    private string $orientation;
    private Plateau $plateau;
    /**
     * @var string[] The array of directions (N, E, S, W)
     */
    private array $directions = ['N', 'E', 'S', 'W'];

    public function __construct(int $x, int $y, string $orientation, Plateau $plateau)
    {
        $this->x = $x;
        $this->y = $y;
        $this->orientation = $orientation;
        $this->plateau = $plateau;
    }

    private function turnLeft(): void
    {
        $currentIndex = array_search($this->orientation, $this->directions);

        if ($currentIndex === false) {
            throw new InvalidArgumentException('Invalid orientation.');
        }

        $this->orientation = $this->directions[((int)$currentIndex + 3) % 4];
    }

    private function turnRight(): void
    {
        $currentIndex = array_search($this->orientation, $this->directions);

        if ($currentIndex === false) {
            throw new InvalidArgumentException('Invalid orientation.');
        }

        $this->orientation = $this->directions[((int)$currentIndex + 1) % 4];
    }

    private function move(): void
    {
        switch ($this->orientation) {
            case 'N':
                if ($this->plateau->isWithinLimits($this->x, $this->y + 1)) {
                    $this->y++;
                }
                break;
            case 'E':
                if ($this->plateau->isWithinLimits($this->x + 1, $this->y)) {
                    $this->x++;
                }
                break;
            case 'S':
                if ($this->plateau->isWithinLimits($this->x, $this->y - 1)) {
                    $this->y--;
                }
                break;
            case 'W':
                if ($this->plateau->isWithinLimits($this->x - 1, $this->y)) {
                    $this->x--;
                }
                break;
        }
    }

    public function readAndProcessInstructions(string $instructions): string
    {
        foreach (str_split($instructions) as $instruction) {
            switch ($instruction) {
                case 'L':
                    $this->turnLeft();
                    break;
                case 'R':
                    $this->turnRight();
                    break;
                case 'M':
                    $this->move();
                    break;
            }
        }
        return $this->x . ' ' . $this->y . ' ' . $this->orientation;
    }
}
