<?php

namespace TomF\BattleShips;

use TomF\BattleShips\Point;

class Ship
{
    const ORIENTATION_HORIZTONAL = 1;
    const ORIENTATION_VERTICAL = 2;

    /**
     * @var int
     */
    private $length;

    /**
     * @var int
     */
    private $orientation;

    /**
     * @var Point[]
     */
    private $coordinates = array();

    public function __construct($length, $orientation = self::ORIENTATION_HORIZTONAL)
    {
        $this->length = $length;
        $this->orientation = $orientation;
    }

    public function addCoordinate(Point $coord)
    {
        $this->coordinates[] = $coord;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

}
