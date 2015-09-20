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

    /**
     * Here we are testing when a ship overlaps the boundry (ie the 7,9 coord)
     *
     * @expectedException TomF\BattleShips\Exception\PlacementErrorException
     * @expectedExceptionMessage 9, 7 is an invalid placement.
     */
    public function testShipOutofBoundsOverlapPlacement()
    {
        $grid = new Grid(8);
        $ship = new Ship(3);

        $x = 7;
        $y = 7;

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

    /**
     * @expectedException TomF\BattleShips\Exception\PlacementCollisionException
     * @expectedExceptionMessage 3, 3 clashes with another ship.
     */
    public function testShipCollisionPlacement()
    {
        $grid = new Grid(10);
        $ship1 = new Ship(2);
        $ship2 = new Ship(2);

        $grid->placeShip($ship1, 3, 3);
        $grid->placeShip($ship2, 3, 3);
    }

    /**
     * @expectedException TomF\BattleShips\Exception\PlacementCollisionException
     * @expectedExceptionMessage 4, 3 clashes with another ship.
     */
    public function testShipCollisionEndOverlapPlacement()
    {
        $grid = new Grid(10);
        $ship1 = new Ship(2);
        $ship2 = new Ship(2, Ship::ORIENTATION_VERTICAL);

        $grid->placeShip($ship1, 3, 3);
        $grid->placeShip($ship2, 4, 2);
    }

    /**
     * Ships in a line
     */
    public function testShipNoCollisionPlacement()
    {
        $grid = new Grid(10);
        $ship1 = new Ship(2);
        $ship2 = new Ship(2);

        $grid->placeShip($ship1, 3, 3);
        $grid->placeShip($ship2, 5, 3);
    }

    public function testShotsHitMissSink()
    {
        $grid = new Grid(10);
        $ship1 = new Ship(4, Ship::ORIENTATION_VERTICAL);

        $grid->placeShip($ship1, 1, 1);

        $this->assertEquals(Grid::SHOT_MISSES, $grid->receiveShot(5, 5));
        $this->assertEquals(Grid::SHOT_MISSES, $grid->receiveShot(8, 4));
        $this->assertEquals(Grid::SHOT_MISSES, $grid->receiveShot(1, 5));

        $this->assertEquals(Grid::SHOT_HITS, $grid->receiveShot(1, 4));
        $this->assertEquals(Grid::SHOT_HITS, $grid->receiveShot(1, 3));
        $this->assertEquals(Grid::SHOT_HITS, $grid->receiveShot(1, 1));

        $this->assertEquals(Grid::SHOT_SINKS, $grid->receiveShot(1, 2));
    }

    public function testScoreTracking()
    {
        $grid = new Grid(10);
        $ship1 = new Ship(4, Ship::ORIENTATION_VERTICAL);

        $grid->placeShip($ship1, 1, 1);

        $grid->receiveShot(5, 5);
        $grid->receiveShot(8, 4);
        $grid->receiveShot(1, 5);

        $grid->receiveShot(1, 4);
        $grid->receiveShot(1, 3);
        $grid->receiveShot(1, 1);

        $grid->receiveShot(1, 2);

        $this->assertEquals(7, $grid->getShotsCount());
        $this->assertEquals(4, $grid->getHitsCount());
        $this->assertEquals(1, $grid->getSinksCount());

    }

}
