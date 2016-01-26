<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table categories
 *
 * @author Jack
 * @version 1.0
 * @date Sat Mar 14 12:45:45 2015
 *
 * @Clips\Model(table="categories")
 */
class CategoryModel extends DBModel {

	const PRODUCT_NAME = '产品';
	const COUPON_NAME = '优惠券';
	const COUPON_TYPE = 'products';

	public function getCouponCategoryId() {
		$coupon = $this->one(array(
			'name' => CategoryModel::COUPON_NAME
		));
		if(!isset($coupon->id)){
			return $this->insert((object)array(
				'parent_id' => $this->getProductID(),
				'name' => CategoryModel::COUPON_NAME,
				'type' => CategoryModel::COUPON_TYPE
			));
		}
		return $coupon->id;
	}

	public function getProductID(){
		$product = $this->one(array(
			'name' => CategoryModel::PRODUCT_NAME
		));
		if(!isset($product->id)){
			return $this->insert((object)array(
				'name' => CategoryModel::PRODUCT_NAME,
				'type' => CategoryModel::COUPON_TYPE
			));
		}
		return $product->id;
	}
}
