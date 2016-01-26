<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table merchants
 *
 * @author Jack
 * @version 1.0
 * @date Sun Mar 15 12:08:08 2015
 *
 * @Clips\Model
 */
class MerchantModel extends DBModel {
	const ACTIVE = 'ACTIVE';
    public function getMerchant($mid){
        if(!$mid){
            return array();
        }
        return $this->one(array(
            'id' => $mid
        ));
    }

	public function getMerchantID($uid){
		if(!$uid)
			return null;
		return $this->one(array(
				'id'=>$uid
		));
	}

	public function getMerchantsID(){
		return $this->select('merchants.name,merchants.description')->from('products')->join('merchants',
				array('merchants.id' => 'products.merchant_id'))->where(array(
				'products.status' => MerchantModel::ACTIVE
		))->orderBy('products.name')->result();
	}

	public function getCurrentMerchantID() {
		$request = \Clips\context('request');
		if($request) {
			return $request->session('merchant_id');
		}
		else {
			\Clips\error('Trying to get user\'s login infor when no request is there.');
		}
		return false;
	}

	public function setMerchantID($mid) {
		$request = \Clips\context('request');
		if($request)
			$request->session('merchant_id', $mid);
	}

	public function getMerchants(){
		$mid = $this->getCurrentMerchantID();
		return $this->select('merchants.id,merchants.name,merchants.description,merchants.parent')->from('merchants')->where(array(
				'merchants.parent' => $mid
		))->orderBy('merchants.id')->result();
	}
	public function getMerchantsByName($m_name){
		return $this->one(array(
				'name' => $m_name
		));
	}

	public function getTestByUid($uid){
		if(!$uid)
			return null;
		return $this->get(array(
				'uid'=>$uid
		));
	}

	public function getMerchantsIDByProductID($product_id){
		return $this->select('merchants.id,merchants.name,merchants.description')->from('products')->join('merchants',
				array('merchants.id' => 'products.merchant_id'))->where(array(
				'products.id' =>$product_id
		))->orderBy('products.name')->result();
	}

	public function getMerchantsByParentID($pid){
		return $this->get(array('parent'=>$pid));
	}

	public function getParentID($mid){
		return $this->one('id',$mid)->parent;
	}

}
