<?php

namespace TomF\BattleShips;

use TomF\BattleShips\Ship;
use TomF\BattleShips\Point;
use TomF\BattleShips\Exception\PlacementErrorException;

/**
 * Class that allows creation of a square battle ships grid.
 */
class Grid
{

    private $size;

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
        $this->checkBounds($x, $y);

        // Get coords for ship given x,y
        switch ($ship->getOrientation()) {
            case Ship::ORIENTATION_VERTICAL:
                for ($i = 1; $i <= $ship->getLength(); $i++) {
                    $newX = $x;
                    $newY = $y+$i;
                    $this->checkBounds($newX, $newY);
                    $point = new Point($newX, $newY);
                    $ship->addCoordinate($point);
                }
                break;
            case Ship::ORIENTATION_HORIZTONAL:
                for ($i = 1; $i <= $ship->getLength(); $i++) {
                    $newX = $x;
                    $newY = $y+$i;
                    $this->checkBounds($newX, $newY);
                    $point = new Point($newX, $newY);
                    $ship->addCoordinate($point);
                }
                break;
        }

        return true;
    }

    public function checkBounds($x, $y)
    {
        if ($x < 0 || $y < 0 || $x > $this->size || $y > $this->size) {
            throw new PlacementErrorException($x, $y);
        }
    }

}
