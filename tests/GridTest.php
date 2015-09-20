<?php

use TomF\BattleShips\Grid;
use TomF\BattleShips\Ship;

Class GridTest extends PHPUnit_Framework_TestCase {

    public function testGridCreate()
    {
        $this->assertInstanceOf('TomF\BattleShips\Grid', new Grid(10));
    }

    public function testOutOfBoundsPlacement()
    {
        $grid = new Grid(10);
        $ship = new Ship(3);

        $x = 2;
        $y = 2;

        $res = $grid->placeShip($ship, $x, $y);
    }

    /**
     * @expectedException TomF\BattleShips\Exception\PlacementErrorException
     * @expectedExceptionMessage -1, 2 is an invalid placement.
     */
    public function testShipOutofBoundsLeftPlacement()
    {
        $grid = new Grid(10);
        $ship = new Ship(3);

        $x = -1;
        $y = 2;

        $res = $grid->placeShip($ship, $x, $y);
    }

    /**
     * @expectedException TomF\BattleShips\Exception\PlacementErrorException
     * @expectedExceptionMessage 9, 2 is an invalid placement.
     */
    public function testShipOutofBoundsRightPlacement()
    {
        $grid = new Grid(8);
        $ship = new Ship(3);

        $x = 9;
        $y = 2;

        $res = $grid->placeShip($ship, $x, $y);
    }

    /**
     * @expectedException TomF\BattleShips\Exception\PlacementErrorException
     * @expectedExceptionMessage 4, -1 is an invalid placement.
     */
    public function testShipOutofBoundsTopPlacement()
    {
        $grid = new Grid(8);
        $ship = new Ship(3);

        $x = 4;
        $y = -1;

        $res = $grid->placeShip($ship, $x, $y);
    }

    /**
     * @expectedException TomF\BattleShips\Exception\PlacementErrorException
     * @expectedExceptionMessage 3, 10 is an invalid placement.
     */
    public function testShipOutofBoundsBottomPlacement()
    {
        $grid = new Grid(8);
        $ship = new Ship(3);

        $x = 3;
        $y = 10;

        $res = $grid->placeShip($ship, $x, $y);
    }

    public function testShipValidPlacement()
    {
        $grid = new Grid(10);
        $ship = new Ship(3);

        $x = 2;
        $y = 2;

        $res = $grid->placeShip($ship, $x, $y);

        $this->assertTrue($res);
    }

}
