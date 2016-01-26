<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table order_items
 *
 * @author Jack
 * @version 1.0
 * @date Sun Mar 15 12:08:08 2015
 *
 * @Clips\Model({"orderItem","product","customerProduct","paymentMethod","category","merchant"})
 */
class OrderItemModel extends DBModel {
    public function addOrderItem($post,$orderID,$uid){
        $now = new \DateTime();
        $data['product_id']=$post['product_id'][0];
        $data['order_id']=$orderID;
        $data['uid']=$uid;
        $data['amount']=$post['number'][0];
        $data['price']=$post['discount_price'][0];
        $data['timestamp']=$now->format('Y-m-d H:i:s');
        $data['create_date']=$now->format('Y-m-d H:i:s');
        $orderItemID=$this->insert($data);
        if(!$orderItemID){
            return $this->error('This OrderItemID is Null');
        }
        return $orderItemID;
    }

    public function getProductAmount($product_id) {
        return $this->select('*')->from($this->table)->where(array('product_id' => $product_id))
            ->orderby('rand()')->result();
    }

	public function getOrderItemByID($order_id) {
		return  $this->select('order_items.order_id,orders.timestamp,products.category_id,orders.id,orders.status,orders.name,orders.create_date,order_items.amount,order_items.price,orders.order_number,order_items.product_id')->from('products')->join('orders',array('orders.id'=>'order_items.order_id'))->join('order_items',
				array('order_items.product_id' => 'products.id'))->where(array(
				'orders.id' => $order_id
		))->orderBy('orders.id')->result();
	}

	public function getOrderItemByOrderID($order_id){
		return $this->one(array('order_id'=> $order_id));
	}

	public function getOrderDetails($order_id){
		$order_details = $this->orderitem->getOrderItemByID($order_id);
		$order_details[0]->totalPrice = $order_details[0]->price * $order_details[0]->amount;
		$product=$this->product->load($order_details[0]->product_id);
		$order_details[0]->p_amount=$product->amount;
		$order_details[0]->category_id = $product->category_id;
		if($order_details[0]->category_id =="1"){
			$order_details[0]->status = $order_details[0]->status;
		}
		if($order_details[0]->category_id == $this->category->getCouponCategoryId() && $order_details[0]->status == 'PAY'){
			$customerproducts = $this->customerproduct->getCodeByProductID($order_id);
			$order_details[0]->code = $customerproducts[0]->code;
		}else{
			$order_details[0]->code = '';
		}
		if($order_details[0]->category_id == $this->category->getCouponCategoryId() && $order_details[0]->status == 'PAY' && $customerproducts[0]->status=='USED'){
			$order_details[0]->status = $customerproducts[0]->status;
		}else{
			$order_details[0]->status = $order_details[0]->status;
		}
		$payments = $this->paymentmethod->get('status','ACTIVE');
		$order_details[0]->payment_name = $payments[0]->name;
		$order_details[0]->expire_date = $product->expire_date;
		return $order_details[0];
	}

	public function getOrderItemByUid($user_id,$type) {
		$where = array();
		if($type=='product') {
			$where['products.category_id'] = 1;
		}elseif($type=='bestpay_coupon'){
			$where['products.category_id'] = 2;
		}elseif($type=='my_coupon') {

		}else{
			$where['order_items.uid'] = $user_id;
		}

		return  $this->select('orders.timestamp,orders.status,products.name,products.category_id,orders.order_number,orders.create_date,order_items.order_id,order_items.product_id,order_items.amount,order_items.price,GROUP_CONCAT(product_photos.path) as path')->from('order_items')

				->join('product_photos', array('product_photos.product_id' => 'products.id'))
				->join('products',array('products.id'=>'order_items.product_id'))

				->join('orders', array('orders.id' => 'order_items.order_id'))
				->join('users', array('users.id' => 'order_items.uid'))
				->where($where)->groupBy('order_items.id')->orderBy('order_items.id')->result();
	}

	public function getMerchantOrderItem($type) {
		if($type=='product') {
			$where['orders.type'] = null;
			$where['products.category_id'] = 1;
		}elseif($type=='bestpay_coupon'){
			$where['orders.type'] = null;
			$where['products.category_id'] = 2;
		}elseif($type=='my_coupon') {
			new \Clips\Libraries\NotOperator(array('orders.type' => null));
		}
		return  $this->select('orders.merchant_id,orders.consignee_name,orders.consignee_mobile,consignee_address,orders.status,products.name,orders.order_number,orders.timestamp,order_items.order_id,order_items.amount,order_items.price,GROUP_CONCAT(product_photos.path) as path')->from('order_items')
				->join('product_photos', array('product_photos.product_id' => 'products.id'))
				->join('products',array('products.id'=>'order_items.product_id'))

				->join('orders', array('orders.id' => 'order_items.order_id'))
				->join('users', array('users.id' => 'order_items.uid'))
				->where($where)
				->groupBy('order_items.id')->orderBy('order_items.id')->result();
	}

	public function getOrderItemByCid($user_id) {
		$cid = $this->category->getCouponCategoryId();
		return  $this->select('orders.status,orders.c_status,order_items.id,orders.uid,products.category_id,products.name,orders.order_number,orders.timestamp,
						order_items.order_id,order_items.amount,order_items.price,GROUP_CONCAT(product_photos.path) as path')
				->from('order_items')
				->join('product_photos', array('product_photos.product_id' => 'products.id'))
				->join('categories',array('categories.id'=>'products.category_id'))
				->join('products',array('products.id'=>'order_items.product_id'))


				->join('orders', array('orders.id' => 'order_items.order_id'))
				->join('users', array('users.id' => 'order_items.uid'))
				->where(array(
						'order_items.uid' => $user_id,
						'products.category_id' =>$cid

				))->groupBy('order_items.id')->orderBy('order_items.id')->result();
	}


	public function getMerchantName(){
		return  $this->select('order_items.id,merchants.name as merchant_name')->from('order_items')
				->join("merchants",array('merchants.id'=>'products.merchant_id'))
				->join('products', array('products.id' => 'order_items.product_id'))

				->orderBy('order_items.id')->result();
	}

	public function getOrderItemsByOrderID($order_id){
		return  $this->select('products.name,order_items.*')->from('order_items')
				->join("products",array('products.id'=>'order_items.product_id'))
				->where(array('order_items.order_id'=>$order_id))
				->orderBy('order_items.id')->result();
	}

	public function getOrderItemsByOid($order_id,$type){

		if($type=='product') {
			$where['products.category_id'] = 1;
		}elseif($type=='bestpay_coupon'){
			$where['products.category_id'] = 2;
		}
		$where['order_items.order_id'] = $order_id;
		return  $this->select('order_items.id as item_id,products.category_id,orders.consignee_mobile,orders.consignee_address,orders.consignee_name,products.expire_date,products.name,orders.order_number,orders.timestamp,order_items.order_id,order_items.amount,order_items.price,GROUP_CONCAT(product_photos.path) as path')->from('order_items')
				->join('product_photos', array('product_photos.product_id' => 'products.id'))
				->join('products',array('products.id'=>'order_items.product_id'))

				->join('orders', array('orders.id' => 'order_items.order_id'))
				->join('users', array('users.id' => 'order_items.uid'))
				->where($where)->groupBy('order_items.id')->orderBy('order_items.id')->result();
	}

	public function getOrderItemByItemID($item_id){
		return  $this->select('products.expire_date,products.name,orders.order_number,orders.timestamp,
								order_items.order_id,order_items.amount,order_items.price,
								product_photos.path as path')
				->from('order_items')
				->join('product_photos', array('product_photos.product_id' => 'products.id'))
				->join('products',array('products.id'=>'order_items.product_id'))

				->join('orders', array('orders.id' => 'order_items.order_id'))
				->join('users', array('users.id' => 'order_items.uid'))
				->where(array(
						'order_items.id' => $item_id,
				))->groupBy('order_items.id')->orderBy('order_items.id')->result();
	}

}
