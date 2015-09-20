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

    /**
     * True if a hit occurs, false if not.
     *
     * @return bool
     */
    public function testHit($x, $y)
    {
        $hit = false;
        foreach ($this->coordinates as $point) {
            /** @var Point $point **/
            if ($point->testHit($x, $y)) {
                $hit = true;
            }
        }

        return $hit;
    }

    /**
     * @return float
     */
    public function getHitPercentage()
    {
        $hits = $this->countHits();

        return ($hits/$this->length)*100;
    }

    /**
     * @return bool
     */
    public function anyHits()
    {
        return ($this->countHits() > 0);
    }

    /**
     * @return bool
     */
    public function isSunk()
    {
        return ($this->length == $this->countHits());
    }

    /**
     * @return int
     */
    private function countHits()
    {
        $hits = 0;
        foreach ($this->coordinates as $point) {
            /** @var Point $point **/
            if ($point->isHit()) {
                $hits++;
            }
        }

        return $hits;
    }

}
