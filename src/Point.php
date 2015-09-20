<?php

namespace TomF\BattleShips;

class Point
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @var boolean
     */
    private $isHit;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

}
