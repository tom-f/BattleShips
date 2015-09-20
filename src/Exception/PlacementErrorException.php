<?php

namespace TomF\BattleShips\Exception;

class PlacementErrorException extends \Exception
{

    public function __construct($x, $y)
    {
        parent::__construct("{$x}, {$y} is an invalid placement.");
    }
}
