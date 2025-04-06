<?php

namespace App;

class Plateau
{
    private int $xMax;
    private int $yMax;

    public function __construct(int $xMax, int $yMax)
    {
        $this->xMax = $xMax;
        $this->yMax = $yMax;
    }

    public function isWithinLimits(int $x, int $y): bool
    {
        return $x >= 0 && $x <= $this->xMax && $y >= 0 && $y <= $this->yMax;
    }
}
