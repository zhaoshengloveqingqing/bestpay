<?php

use Pinet\BestPay\Libraries\FakeDataSource;

/**
 * @author Jack
 * @date Tue Jun  9 11:24:51 2015
 * @Clips\Model("place")
 */
class PlaceModelTest extends Clips\TestCase {

	public function testListProvince(){
		$this->assertNotNull($this->place);
		$this->assertTrue(count($this->place->listProvince()) > 10);
	}

	public function testListCity(){
		$province = 2; // Beijing
		$cities = $this->place->listCity($province);
		$this->assertEquals(count($cities), 1);
		$beijing = $cities[0];
		$this->assertEquals($beijing->id, 52);
	}

	public function testListArea(){
		$city = 52; // Beijing
		$ds = $this->place->listArea($city);
		$this->assertEquals(count($ds), 18);
	}
}
