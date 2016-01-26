<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table merchant_products
 *
 * @author Jack
 * @version 1.0
 * @date Sun Mar 15 12:08:08 2015
 *
 * @Clips\Model
 */
class MerchantProductModel extends DBModel {

	const ACTIVE = 'ACTIVE';

	public function getRelate($pid, $mid){
		return $this->one(array(
			'product_id'=>$pid,
			'mid'=>$mid
		));
	}

	public function getMerchantProducts($mid){
		return $this->select('distinct products.id, products.name')
				->from('merchant_products')
				->join('products',array('products.id' => 'merchant_products.product_id'))
				->where(array(
						'merchant_products.mid' => $mid,
						'products.status' => MerchantProductModel::ACTIVE,
						'products.category_id'=>2,
						new \Clips\Libraries\CommonOperator('products.expire_date', date('Y-m-d H:i:s', time()), '>=')
					))
				->orderBy('products.name')->result();
	}

	public function merchantProduct($product_id,$mid){
		$now = new \DateTime();
		$data['product_id'] = $product_id;
		$data['mid'] = $mid;
		$data['create_date'] = $now->format('Y-m-d H:i:s');
		$data['timestamp'] = $now->format('Y-m-d H:i:s');
		return  $this->insert($data);

	}
}
