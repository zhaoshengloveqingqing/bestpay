<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * @Clips\Model
 */
class PlaceModel extends DBModel {

	const PROVINCE = 1;
	const CITY = 2;
	const DISTRICT = 3;


	public function listProvince() {
		return $this->get('type', PlaceModel::PROVINCE);
	}

	public function listCity($province) {
		if($province)
			return $this->get('parent_id', $province);
		return array();
	}

	public function listArea($city = 0) {
		if($city)
			return $this->get('parent_id', $city);
		return array();
	}

	public function getElementName($id){
		return $this->one('id', $id);
	}
}
