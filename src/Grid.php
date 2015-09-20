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

    private $size;

    /**
     * @var Ship[]
     */
    private $ships = array();

    public function __construct($size)
    {
        $this->size = $size;
    }

    // public function addShip()

    /**
    * Placement assumes x,y represent stern (back of ship)
    * @todo: Convert to use strategy pattern, possibly placement from bow or other?
    */
    public function placeShip(Ship $ship, $x, $y)
    {
        // check in bounds
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

    private function addShip(Ship $ship)
    {
        $this->ships[] = $ship;
    }

}
