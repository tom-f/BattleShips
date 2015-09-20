<?php

use TomF\BattleShips\Ship;

Class ShipTest extends PHPUnit_Framework_TestCase {

   public function testShipCreateWithoutOrientation()
   {
       $this->assertInstanceOf('TomF\BattleShips\Ship', new Ship(1));
   }

}
