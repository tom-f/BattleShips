<?php

use TomF\BattleShips\Ship;
use TomF\BattleShips\Point;

Class ShipTest extends PHPUnit_Framework_TestCase {

   public function testShipCreateWithoutOrientation()
   {
       $this->assertInstanceOf('TomF\BattleShips\Ship', new Ship(1));
   }


   public function testShipHitPercentage()
   {
       $ship = new Ship(4);
       $ship->addCoordinate(new Point(1, 2));
       $ship->addCoordinate(new Point(2, 2));
       $ship->addCoordinate(new Point(3, 2));
       $ship->addCoordinate(new Point(4, 2));

       $this->assertEquals(0, $ship->getHitPercentage());

       //Hit one
       $ship->testHit(1, 2);

       $this->assertEquals(25, $ship->getHitPercentage());

       //Hit two
       $ship->testHit(2, 2);
       $this->assertEquals(50, $ship->getHitPercentage());

       //Hit two more
       $ship->testHit(3, 2);
       $ship->testHit(4, 2);
       $this->assertEquals(100, $ship->getHitPercentage());
   }

   public function testShipNoHits()
   {
       $ship = new Ship(3);
       $ship->addCoordinate(new Point(1, 2));
       $ship->addCoordinate(new Point(2, 2));
       $ship->addCoordinate(new Point(3, 2));

       $this->assertFalse($ship->anyHits());
   }

   public function testShipIsHit()
   {
       $ship = new Ship(3);
       $ship->addCoordinate(new Point(1, 2));
       $ship->addCoordinate(new Point(2, 2));
       $ship->addCoordinate(new Point(3, 2));

       // Hit ship once
       $ship->testHit(2, 2);

       $this->assertTrue($ship->anyHits());
   }

   public function testShipSunk()
   {
       $ship = new Ship(2);
       $ship->addCoordinate(new Point(1, 2));
       $ship->addCoordinate(new Point(2, 2));

       // Hit Twice;
       $ship->testHit(1, 2);
       $ship->testHit(2, 2);

       $this->assertTrue($ship->isSunk());
   }

   public function testShipNotNoHitsSunk()
   {
       $ship = new Ship(2);

       // One Hit

       $this->assertFalse($ship->isSunk());
   }

   public function testShipNotHalfHitsSunk()
   {
       $ship = new Ship(2);

       // No Hits

       $this->assertFalse($ship->isSunk());
   }

}
