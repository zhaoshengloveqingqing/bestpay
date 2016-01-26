<?php namespace Pinet\BestPay\Libraries; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\BaseService;

/**
 * The library for shpping cart
 *
 * @author Jack
 * @date Sun Mar 15 16:49:21 2015
 * @version 1.0
 *
 * @Clips\Model({"cart", "user"})
 */
class Cart extends BaseService {

	/**
	 * Get cart items for current user
	 */
	public function items() {
		$id = $this->user->getCurrentUserId();
		if($id &&
		   	$this->user->isCustomer($id)) { // Only customer can have cart
			return $this->cart->items($id);
		}
		return array();
	}	

	/**
	 * Add the product to cart
	 */
	public function add($pid, $amount = 1) {
		$id = $this->user->getCurrentUserId();
		if($id) {
			return $this->cart->add($id, $pid, $amount);
		}
		return false;
	}

	/**
	 * Modify the product in cart
	 */
	public function modify($pid, $amount) {
		$id = $this->user->getCurrentUserId();
		if($id) {
			return $this->cart->modify($id, $pid, $amount);
		}
		return false;
	}

	/**
	 * Remove the product from the cart
	 */
	public function remove($pid) {
		$id = $this->user->getCurrentUserId();
		if($id) {
			return $this->cart->remove($id, $pid);
		}
		return false;
	}

	/**
	 * Clean the cart
	 */
	public function clean() {
		$id = $this->user->getCurrentUserId();
		if($id) {
			return $this->cart->clean($id);
		}
		return false;
	}
}
