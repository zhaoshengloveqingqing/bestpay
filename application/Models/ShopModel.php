<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * @Clips\Model({"merchantProduct", "merchant"})
 */
class ShopModel extends DBModel {

	public function listBranch() {
		$mid = $this->merchant->getCurrentMerchantID();
		$parentID = $this->merchant->getParentID($mid);
		$merchant = $this->merchant->one('id',$parentID);
		if($parentID) {
			$merchants = $this->merchant->getMerchantsByParentID($parentID);
			array_unshift($merchants,$merchant);
		}else{
			$merchants[0] = $merchant;
		}
		return $merchants;
	}

	public function listGroup_purchase($merchant) {
//		var_dump($merchant);die;
		if($merchant){
			return  $this->merchantproduct->getMerchantProducts($merchant);
		}

		return array();
	}

//	public function getElementName($id){
//		return $this->one('id', $id);
//	}
}
