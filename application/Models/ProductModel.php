<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table products
 *
 * @author Jack
 * @version 1.0
 * @date Sat Mar 14 12:45:45 2015
 *
 * @Clips\Model({"category", "customerProduct", "merchantProduct","order"})
 */
class ProductModel extends DBModel {

	const ACTIVE = "ACTIVE";

	/**
	 * Get random coupons
	 */
	public function getCoupons() {
		$cid = $this->category->getCouponCategoryId();
        return  $this->select('products.amount ,product_photos.path ,products.id, products.name ,products.category_id,products.note')->from('products')->join('categories',
            array('categories.id' => 'products.category_id'))->join('product_photos',array('product_photos.product_id'=>'products.id'))->where(array(
            'products.category_id' => $cid
        ))->orderBy('products.id')->result();
	}

	public function isCoupon($product) {
		if($product && isset($product->category_id)) {
			return $product->category_id == $this->category->getCouponCategoryId();
		}
	}

	public function getNewProductByTag($cid, $tag_id, $limit=1) {
		return  $this->select('product_photos.path,product_tags.tag_id,products.expire_date,products.price,products.discount_price,products.amount  ,products.id, products.name ,products.category_id,products.note')->from('products')
				->join('product_tags',array('product_tags.product_id'=>'products.id'))
				->join('merchants',array('merchants.id'=>'products.merchant_id'))
				->join('categories',array('categories.id' => 'products.category_id'))
				->join('product_photos',array('product_photos.product_id'=>'products.id'))
				->where(array('products.category_id' => $cid,'product_tags.tag_id'=>$tag_id,'product_photos.is_primary'=>'0'
				))->groupBy('products.id')->orderby('rand() asc','product_photos.is_primary DESC')->limit(0,$limit)->result()[0];
	}

	public function getRecProductByTag($cid, $tag_id, $limit=1) {
		return  $this->select('product_photos.path,product_tags.tag_id,products.expire_date,products.price,products.discount_price,products.amount  ,products.id, products.name ,products.category_id,products.note')->from('products')
				->join('product_tags',array('product_tags.product_id'=>'products.id'))
				->join('merchants',array('merchants.id'=>'products.merchant_id'))
				->join('categories',array('categories.id' => 'products.category_id'))
				->join('product_photos',array('product_photos.product_id'=>'products.id'))
				->where(array('products.category_id' => $cid,'product_tags.tag_id'=>$tag_id,'product_photos.is_primary'=>'0'
				))->groupBy('products.id')->orderby('rand() asc','product_photos.is_primary DESC')->limit(0,$limit)->result()[0];
	}

	public function getProductByLowPrice($cid, $tag_id, $limit=1) {
		return  $this->select('product_photos.path,product_tags.tag_id,products.expire_date,products.price,products.discount_price,products.amount  ,products.id, products.name ,products.category_id,products.note')->from('products')
				->join('product_tags',array('product_tags.product_id'=>'products.id'))
				->join('merchants',array('merchants.id'=>'products.merchant_id'))
				->join('categories',array('categories.id' => 'products.category_id'))
				->join('product_photos',array('product_photos.product_id'=>'products.id'))
				->where(array('products.category_id' => $cid,'product_tags.tag_id'=>$tag_id,'product_photos.is_primary'=>'0'
				))->orderby('rand() asc')->groupBy('products.id')->limit(0,$limit)->result()[0];
	}
	public function getNewProductByLast($cid, $tag_id, $limit=1) {
		return  $this->select('product_photos.path,product_tags.tag_id,products.expire_date,products.price,products.discount_price,products.amount  ,products.id, products.name ,products.category_id,products.note')->from('products')
				->join('product_tags',array('product_tags.product_id'=>'products.id'))
				->join('merchants',array('merchants.id'=>'products.merchant_id'))
				->join('categories',array('categories.id' => 'products.category_id'))
				->join('product_photos',array('product_photos.product_id'=>'products.id'))
				->where(array('products.category_id' => $cid,'product_tags.tag_id'=>$tag_id,'product_photos.is_primary'=>'0'
				))->groupBy('products.id')->orderby('rand() asc','product_photos.is_primary DESC')->limit(0,$limit)->result()[0];
	}

	public function getMallProductByTag($cid, $tag_id, $limit=4) {
		return  $this->select('product_photos.path,product_tags.tag_id,products.expire_date,products.price,products.discount_price,products.amount  ,products.id, products.name ,products.category_id,products.note')->from('products')
				->join('product_tags',array('product_tags.product_id'=>'products.id'))
				->join('merchants',array('merchants.id'=>'products.merchant_id'))
				->join('categories',array('categories.id' => 'products.category_id'))
				->join('product_photos',array('product_photos.product_id'=>'products.id'))
				->where(array('products.category_id' => $cid,'product_tags.tag_id'=>$tag_id,'product_photos.is_primary'=>'1'
		))->groupBy('products.id')->orderby('rand() asc','product_photos.is_primary DESC')->limit(0,$limit)->result();
	}

	public function getProductByTag($cid, $tag_id, $limit=6) {
		return  $this->select('product_photos.path,product_tags.tag_id,products.expire_date,products.price,products.discount_price,products.amount  ,products.id, products.name ,products.category_id,products.note')->from('products')
				->join('product_tags',array('product_tags.product_id'=>'products.id'))
				->join('merchants',array('merchants.id'=>'products.merchant_id'))
				->join('categories',array('categories.id' => 'products.category_id'))
				->join('product_photos',array('product_photos.product_id'=>'products.id'))
				->where(array('products.category_id' => $cid,'product_tags.tag_id'=>$tag_id,'product_photos.is_primary'=>'1'
				))->orderby('products.id asc')->groupBy('products.id')->limit(0,$limit)->result();
	}

    public function getProductByID($id) {
        return  $this->select('products.amount ,product_photos.path ,products.id, products.name ,products.category_id,products.note')->from('products')->join('categories',
            array('categories.id' => 'products.category_id'))->join('product_photos',array('product_photos.product_id'=>'products.id'))->where(array(
            'products.id' => $id
        ))->orderBy('products.id')->result();
    }

	public function getValidProduct($id){
		$now = new \DateTime();
		return $this->one(array(
			'id'=>$id,
			'status'=>ProductModel::ACTIVE,
			new \Clips\Libraries\CommonOperator('expire_date', $now->format('Y-m-d H:i:s'), '>=')
		));
	}

	public function useCode($code, $mid){
		$coupon = $this->customerproduct->getByCode($code);
		if(!isset($coupon->id) || $coupon->status != ProductModel::ACTIVE)
			return false;
		$order = $this->order->getOrderByItemID($coupon->item_id)[0];
//		var_dump($order);die;
		if($order->status == 'NOPAY' || $order->status == 'USERCANCELLED') {
			return false;
		}
		$product = $this->getValidProduct($coupon->product_id);
		if(!isset($product->id)){
			return false;
		}

		$relate = $this->merchantproduct->getRelate($product->id, $mid);
		if(!isset($relate->id)){
			return false;
		}

		$this->order->updateStatus($order->id,'USE');
		return $this->customerproduct->useCode($coupon->id);
	}

    public function updateProduct($product,$id,$amount){
        $now = new \DateTime();
        if(isset($id)){
            return $this->update((object)array(
                'id' =>$id,
                'amount' =>$product->amount-$amount,
                'timestamp' =>$now->format('Y-m-d H:i:s')
            ));
        }
        return false;
    }


	public function getProductsByCart($product_id){
		$res =  $this->select('products.category_id,merchants.name as merchant_name,products.merchant_id,carts.product_id,carts.amount as number,products.name,products.discount_price as price,GROUP_CONCAT(product_photos.path) as path,product_photos.is_primary
		,products.discount_price,product_photos.path')->from('products')
				->join('categories', array('categories.id' => 'products.category_id'))
				->join("product_photos",array('product_photos.product_id'=>'products.id'))
				->join('users', array('users.id' => 'customers.uid'))
				->join('customers', array('customers.id' => 'carts.cid'))
				->join('carts', array('carts.product_id' => 'products.id'))
				->join('merchants', array('merchants.id' => 'products.merchant_id'))
				->where(array(
						'products.id' => $product_id,
						'product_photos.is_primary'=>'0'
				))->groupBy('products.id')->orderBy('users.id')->result()[0];
//		var_dump($res,$product_id);die('dsadf');
		return $res;
	}

	public function getCashCoupon($user_id,$status,$offset,$count) {
		$status = strtoupper($status);
		return  $this->select('orders.note,merchants.name as merchant_name,products.create_date,products.expire_date,orders.status,products.name,orders.order_number,orders.timestamp,order_items.order_id,order_items.amount,round(products.discount_price,0) as discount_price')
				->from('orders')
//				->join('product_photos', array('product_photos.product_id' => 'products.id'))
				->join('merchants',array('merchants.id'=>'products.merchant_id'))
				->join('products',array('products.id'=>'order_items.product_id'))


				->join('order_items', array('order_items.order_id' => 'orders.id'))
				->join('users', array('users.id' => 'orders.uid'))
				->where(array(
						'order_items.uid' => $user_id,
						'orders.type'=>$status

				))
				->groupBy('orders.id')
				->orderBy('orders.id')
				->limit($offset,$count)
				->result();
	}

	public function getCashCouponCount($user_id,$status) {
		$status = strtoupper($status);
		$res =  $this->select('orders.note,merchants.name as merchant_name,products.create_date,products.expire_date,orders.status,products.name,orders.order_number,orders.timestamp,order_items.order_id,order_items.amount,round(products.discount_price,0) as discount_price')
				->from('orders')
//				->join('product_photos', array('product_photos.product_id' => 'products.id'))
				->join('merchants',array('merchants.id'=>'products.merchant_id'))
				->join('products',array('products.id'=>'order_items.product_id'))


				->join('order_items', array('order_items.order_id' => 'orders.id'))
				->join('users', array('users.id' => 'orders.uid'))
				->where(array(
						'order_items.uid' => $user_id,
						'orders.type'=>$status

				))
				->groupBy('orders.id')
				->orderBy('orders.id')
				->result();
		return count($res);
	}

	public function getProductPhotosByPid($product_id){
		return  $this->select('GROUP_CONCAT(product_photos.path) as path,product_photos.is_primary
		,products.discount_price,product_photos.path,products.category_id')->from('products')
				->join("product_photos",array('product_photos.product_id'=>'products.id'))
				->where(array(
						'products.id' => $product_id,
						'product_photos.is_primary'=>'1'
				))->groupBy('products.id')->orderBy('products.id')->result()[0];
	}

	public function getPostProducts($product_get){
		if($product_get=='product_get'){
			$request = \Clips\context('request');
			$request->session('is_cart','');
			$sess=$request->session('product_data');
			$request->session('spm','');
			$products = $this->getProductsByCart($sess['id']);
			$merchants =array((Object) $products);
			$product_count = count($sess['id']);
			return array($sess,$merchants,$product_count);
		}

	}

	public function getProductsByKey($key){
		$now = new \DateTime();

		return  $this->select('product_photos.path,product_tags.tag_id,products.expire_date,products.price,products.discount_price,products.amount  ,products.id, products.name ,products.category_id,products.note')->from('products')
				->join('product_tags',array('product_tags.product_id'=>'products.id'))
				->join('merchants',array('merchants.id'=>'products.merchant_id'))
				->join('categories',array('categories.id' => 'products.category_id'))
				->join('product_photos',array('product_photos.product_id'=>'products.id'))
				->where(array(
						'product_photos.is_primary'=>'1',
						new \Clips\Libraries\LikeOperator('products.name', '%'.$key.'%'),
						new \Clips\Libraries\CommonOperator('products.expire_date', $now->format('Y-m-d H:i:s'), '>=')))
				->orderby('products.id asc')->groupBy('products.id')->result();
	}
}
