<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table carts
 *
 * @author Jack
 * @version 1.0
 * @date Sun Mar 15 12:08:08 2015
 *
 * @Clips\Model
 */
class CartModel extends DBModel {
	/**
	 * Add product to cart
	 */
	public function add($cid, $pid,$number, $amount = 1) {
		$p = $this->one(array('cid' => $cid, 'product_id' => $pid));
		if($p) {
			// We already has this product in the cart
			return $this->update((object)array('id'=>$p->id,'cid'=>$p->cid,'product_id'=>$p->product_id,'amount'=>$p->amount+$number));
		}
		return $this->insert((object) array('cid' => $cid, 'product_id' => $pid, 'amount' => $number));
	}

	/**
	 * Get items for user
	 */
	public function items($cid) {
		$this->select('products.name', 'products.price', 
			'prodcuts.discount_price', 'prodcuts.amount',
			'merchant.name as merchant')
			->from('carts')
			->join('products', array('carts.product_id' => 'products.id'))
			->where(array('carts.cid' => $cid))->result();
	}

	/**
	 * Remove the product from cart
	 */
	public function remove($cid, $pid) {
		$p = $this->one(array('cid' => $cid, 'product_id' => $pid));
		if($p) {
			return $this->delete($p->id);
		}
		return false;
	}

	/**
	 * Modify the product amount in cart
	 */
	public function modify($cid, $pid, $amount) {
		if($amount == 0) {
			$this->remove($cid, $pid);
		}
		$p = $this->one(array('cid' => $cid, 'product_id' => $pid));
		if($p) {
			$p->amount = $amount;
			return  $this->update((object)array(
					'id' =>$p->id,
					'amount' =>$p->amount,
					'cid' =>$p->cid,
					'product_id'=>$p->product_id
			));
		}
		return false;
	}

	/**
	 * Clean cart for user
	 */
	public function clean($cid) {
		$ids = $this->select('id')->from($this->table)
			->where('cid', $cid)->result();
		$this->delete($ids);
	}

	public function getCartCount($uid){
		return  $this->select('count(*) as count,carts.product_id')->from('carts')
				->join('users', array('users.id' => 'customers.uid'))
				->join('customers', array('customers.id' => 'carts.cid'))
				->where(array(
						'users.id' => $uid,
				))->orderBy('users.id')->result()[0];
	}

	public function get_shop_sn() {
		mt_srand((double) microtime() * 1000000);
		$rand_id = mt_rand(1, 99999);
		return $rand_id+100000;
	}

	public function getProductsByCart($user_id){
		$itemId = $this->get_shop_sn();
		return  $this->select('products.amount,carts.id,merchants.name as merchant_name,products.category_id,products.merchant_id,merchants.name as merchant_name,carts.product_id,carts.amount as number,products.name,products.discount_price as price,GROUP_CONCAT(product_photos.path) as path,product_photos.is_primary
		,products.discount_price,product_photos.path')->from('products')
				->join("product_photos",array('product_photos.product_id'=>'products.id'))
				->join("merchants",array('merchants.id'=>'products.merchant_id'))
				->join('users', array('users.id' => 'customers.uid'))
				->join('customers', array('customers.id' => 'carts.cid'))
				->join('carts', array('carts.product_id' => 'products.id'))
				->where(array(
						'users.id' => $user_id,
						'product_photos.is_primary'=>'0'
				))->groupBy('products.id')->orderBy('users.id')->result();
	}

	public function getCartsByProductID($product_id){

		return  $this->select('carts.id,carts.product_id,carts.amount')->from('carts')
				->where(array(
						'carts.product_id' => $product_id,
				))->orderBy('carts.id')->result();
	}

}
