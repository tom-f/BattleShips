<?php

namespace TomF\BattleShips;

use TomF\BattleShips\Ship;
use TomF\BattleShips\Point;
use TomF\BattleShips\Exception\PlacementErrorException;
use TomF\BattleShips\Exception\PlacementCollisionException;

/**
 * Class that allows creation of a square battle ships grid.
 */
class Grid
{
    const SHOT_MISSES = 1;
    const SHOT_HITS = 2;
    const SHOT_SINKS = 3;

    private $size;

    /**
     * Convenience counters...
     * @todo: refactor score trackers
     */
    private $shotsFired = 0;
    private $shotsHit = 0;
    private $shotsSunk = 0;

    /**
     * @var Ship[]
     */
    private $ships = array();

    public function __construct($size)
    {
        $this->size = $size;
    }

    /**
    * Placement assumes x,y represent stern (back of ship)
    * @todo: Convert to use strategy pattern, possibly placement from bow or other?
    */
    public function placeShip(Ship $ship, $x, $y)
    {
        $this->fitShip($x, $y);

        $point = new Point($x, $y);
        $ship->addCoordinate($point);

        // Get coords for ship given x,y
        switch ($ship->getOrientation()) {
            case Ship::ORIENTATION_VERTICAL:
                for ($i = 1; $i < $ship->getLength(); $i++) {
                    $newX = $x;
                    $newY = $y+$i;
                    $this->fitShip($newX, $newY);
                    $point = new Point($newX, $newY);
                    $ship->addCoordinate($point);
                }
                break;
            case Ship::ORIENTATION_HORIZTONAL:
                for ($i = 1; $i < $ship->getLength(); $i++) {
                    $newX = $x+$i;
                    $newY = $y;
                    $this->fitShip($newX, $newY);
                    $point = new Point($newX, $newY);
                    $ship->addCoordinate($point);
                }
                break;
        }

        // If ship makes it this far placement is valid.
        $this->addShip($ship);
        return true;
    }

    private function fitShip($x, $y)
    {
        $this->checkBounds($x, $y);
        $this->checkShipCollision($x, $y);
    }

    private function checkBounds($x, $y)
    {
        if ($x < 0 || $y < 0 || $x > $this->size || $y > $this->size) {
            throw new PlacementErrorException($x, $y);
        }
    }

    private function checkShipCollision($x, $y)
    {
        foreach ($this->ships as $ship) {
            if ($ship->testHit($x, $y)) {
                throw new PlacementCollisionException($x, $y);
            }
        }
    }

    /**
     * Return different status code depending on outcome of shot
     * @todo: currently allow the same shot to be 'fired' multiple times.
     * @todo: probably replace with event dispatcher
     *
     * @return int
     */
    public function receiveShot($x, $y)
    {
        $this->shotsFired++;

        $result = self::SHOT_MISSES;
        foreach ($this->ships as $ship) {
            if ($ship->receiveShot($x, $y)) {
                $this->shotsHit++;
                $result = self::SHOT_HITS;
                if ($ship->isSunk()) {
                    $this->shotsSunk++;
                    $result = self::SHOT_SINKS;
                }
            }
        }

        return $result;
    }

    public function getShotsCount()
    {
        return $this->shotsFired;
    }

    public function getHitsCount()
    {
        return $this->shotsHit;
    }

    public function getSinksCount()
    {
        return $this->shotsSunk;
    }

    private function addShip(Ship $ship)
    {
        $this->ships[] = $ship;
    }

}
