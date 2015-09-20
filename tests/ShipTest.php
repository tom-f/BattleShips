<?php

use TomF\BattleShips\Ship;

Class ShipTest extends PHPUnit_Framework_TestCase {

   public function testShipCreateWithoutOrientation()
   {
       $this->assertInstanceOf('TomF\BattleShips\Ship', new Ship(1));
   }


   public function testShipHitPercentage()
   {
       $ship = new Ship(4);

       $this->assertEquals(0, $ship->getHitPercentage());

       //Hit one
       $this->assertEquals(25, $ship->getHitPercentage());

       //Hit two
       $this->assertEquals(50, $ship->getHitPercentage());

       //Hit two more
       $this->assertEquals(100, $ship->getHitPercentage());
   }

   public function testShipNoHits()
   {
       $ship = new Ship(3);

       $this->assertFalse($ship->anyHits());
   }

   public function testShipIsHit()
   {
       $ship = new Ship(3);

       // Hit ship once

       $this->assertTrue($ship->anyHits());
   }

   public function testShipSunk()
   {
       $ship = new Ship(2);
       // Hit Twice;

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
