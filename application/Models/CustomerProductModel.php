<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table customer_products
 *
 * @author Jack
 * @version 1.0
 * @date Sun Mar 15 12:08:08 2015
 *
 * @Clips\Model({"merchantProduct", "merchant","customer"})
 */
class CustomerProductModel extends DBModel {

	const ACTIVE = "ACTIVE";
	const USED = "USED";

	public function getByCode($code){
		if(!$code)
			return null;
		return $this->one(array(
			'code' => $code
		));
	}

	public function useCode($id){
		$coupon = $this->load($id);
		if(isset($coupon->id)){
			return $this->update((object)array(
				'id' => $coupon->id,
				'status' => CustomerProductModel::USED
			));
		}
		return false;
	}

	public function getCodeByProductID($product_id) {
		return  $this->select('customer_products.status,customer_products.id,customer_products.code,orders.create_date,customer_products.create_date,order_items.order_id')->from('customer_products')
				->join('orders', array('orders.create_date' => 'customer_products.create_date'))
				->join('order_items', array('order_items.product_id' => 'customer_products.product_id'))->where(array(
				'orders.id' => $product_id,
		))->orderBy('customer_products.id')->result();
	}

	public function customerProduct($product_id,$uid,$create_date,$item_id){
		$data['product_id'] = $product_id;
		$data['cid'] = $uid;
		$data['status'] = 'ACTIVE';
		$data['code'] = $this->randomCode();
		$data['create_date'] =  $create_date;
		$data['item_id'] =  $item_id;
		return  $this->insert($data);

	}

	public function getCustomerProduct($cid){
		if(!$cid){
			return array();
		}
		return $this->get(array(
				'cid' => $cid
		));
	}

	public function randomCode( $length = 8 )
	{
		$str = null;
		$strPol = "0123456789abcdefghijklmnopqrstuvwxyz";
		$max = strlen($strPol)-1;

		for($i=0;$i<$length;$i++){
			$str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
		}

		return $str;
	}

	public function getCode($item_id){
		return $this->one('item_id',$item_id)->code;
	}

	public function getCustomerProductByOID($OID,$type){
		if($type=='product') {
			$where['products.category_id'] = 1;
		}elseif($type=='bestpay_coupon'){
			$where['products.category_id'] = 2;
		}
		$where['customer_products.item_id'] = $OID;
		$res = $this->select('orders.distribution_company,orders.distribution_phone,orders.distribution_way,products.category_id,order_items.*,customer_products.*')
				->from('customer_products')
				->join('products',array('products.id'=>'order_items.product_id'))
				->join('orders',array('orders.id'=>'order_items.order_id'))
				->join('order_items',array('order_items.id'=>'customer_products.item_id'))

				->where($where)
				->result();
		return $res;
	}
}
