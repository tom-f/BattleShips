<?php

namespace TomF\BattleShips\Exception;

class PlacementCollisionException extends \Exception
{
    public function __construct($x, $y)
    {
        parent::__construct("{$x}, {$y} clashes with another ship.");
    }
}
