<?php namespace Pinet\BestPay\Controllers\Admin; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\MerchantBaseController;

/**
 * @Clips\MessageBundle(name="merchant")
 * @Clips\Widget({"html", "lang", "grid", "image", "bootstrap", "navigation","yizhifu"})
 * @Clips\Scss("admin_layout/admin_layout")
 */
class MerchantController extends MerchantBaseController {
    /**
     * @Clips\Model("category")
     * @Clips\Widgets\ListView("admin_coupon_index")
     * @Clips\Scss("admin/coupon/index")
     */
    public function index(){
        $this->title('Coupon Page',true);
        $categoryID=$this->category->getCouponCategoryId();
        $p = array('products.category_id' => $categoryID);
        $this->request->session('coupon_index', $p);
        return $this->render('admin/coupon/index');
    }
	/**
	 * @Clips\Model({"merchant","user","customer","customerProduct","cart","order","paymentmethod","orderItem"})
	 * @Clips\Scss("admin/merchant/orders")
	 * @Clips\Form("admin/merchant/orders")
	 * @Clips\Widgets\ListView("admin_merchant_orders")
	 * @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	 * @Clips\Js("application/static/js/admin/merchant/orders.js")
	 */
	public function orders($status='all',$page_no=1){
		$pagesize = 10;
		$offset = ($page_no-1)*$pagesize;
		if($this->post()!=null){
			echo "<script>alert('操作成功！');</script>";
			$this->order->cancel_order($this->post());
		}
		if($status == 'NOPAY'){
			$url = 'admin/merchant/orders/NOPAY/';
		}elseif($status=='PAY'){
			$url = 'admin/merchant/orders/PAY/';
		}elseif($status=='Distributed') {
			$url = 'admin/merchant/orders/Distributed/';
		}elseif($status == 'Assigned'){
			$url = 'admin/merchant/orders/Assigned/';
		}elseif($status == 'Received'){
			$url = 'admin/merchant/orders/received/';
		}elseif($status=='UserCancelled') {
			$url = 'admin/merchant/orders/UserCancelled/';
		}elseif($status=='MerCancelled'){
			$url = 'admin/merchant/orders/MerCancelled/';
		}else {
			$url = 'admin/merchant/orders/all/';
		}
		$total = $this->order->getOrdersCountByMerchant($status,'product');
		$orders =$this->order->getMerchantOrdersByStatus($status,$offset,$pagesize,'product');
		$pagestr = $this->pages($total,$pagesize,$page_no,$url);
		$orderItems = $this->orderitem->getMerchantOrderItem('product');

		for($i=0;$i<count($orderItems);$i++){
			$ss[] =  explode(",",$orderItems[$i]->path);
		}
		for($i=0;$i<count($orderItems);$i++){
			$orderItems[$i]->path = $ss[$i];
		}
		$arr = array();
		$marry = array();
		$mars = array();
		foreach ($orders as $item) {
			in_array($item->merchant_name, $mars) || $mars[] = $item->name;
			$merchant_names = $mars;
		}
		foreach ($orders as $item) {
			in_array($item->merchant_id, $marry) || $marry[] = $item->id;
			$merchants = $marry;

		}
		foreach ($merchants as $marry) {
			foreach ($orderItems as $goods) {
				if ($goods->order_id == $marry) {
					$arr[$marry][] = $goods;
					//unset($goods);
				}
			}
		}

		$merchants_name = array();
		$merchantnames = $this->order->getMerchantName();
		foreach ($merchantnames as $item) {
			in_array($item->merchant_name, $merchants_name) ? function () use (&$item) {
				unset($item);
			} : $merchants_name[]->merchant_name = $item->merchant_name;
//					$merchants=$merchants['merchant_name'];
		}

		array_walk(
				$merchants_name,
				function ($item, $key) use (&$tmp, &$merchants_name) {
					if (in_array($item->merchant_name, $tmp)) {
						unset($merchants_name[$key]);
					} else {
						$tmp[] = $item->merchant_name;
					}
				}
		);
		foreach ($arr as $k=>$v) {
			$total_price = 0;
			foreach ($v as $k1=>$v2) {
				$total_price += $v2->price * $v2->amount;
			}
			$arr[$k]['total_price']=$total_price;
		}
		$current_merchant = $this->merchant->getMerchantID($this->merchant->getCurrentMerchantID());
		$reason = array('库存不足','产品有质量问题','其他原因.....');
		$cancel_reason = array_merge(array('=请选择取消理由='),$reason);
		unset($tmp);
		//print_r($arr[$merchants[0]]);
		$this->title('My Order Page',true);
		$uid = $this->user->getCurrentUserId();
		$p[] = array('users.id' => $uid,'product_photos.is_primary'=>'1');
		$p[] = new \Clips\Libraries\CommonOperator('orders.status', 'DELETE', '!=');
		//自定义查询
		$this->request->session('user_orders', $p);
		$form_action = \Clips\site_url('user/orders');
//			print_r($orderItems);
		//自定义查询
		$this->request->session('admin_merchant_orders', $p);
		$cancel_reason = array_merge(array('=请选择取消理由='),$reason);
//		var_dump($merchants,$arr);die;
		return $this->render('admin/merchant/orders',array("pagestr"=>$pagestr,"current_merchants"=>$current_merchant,"status"=>$status,"orders"=>$arr,"merchants"=>$merchants,"merchant_names"=>$merchantnames,'cancel_reason'=>$cancel_reason,'form_action'=>$form_action));
	}

	/**
	 * @Clips\Model({"user","customer","customerProduct","cart","order","paymentmethod","orderItem"})
	 */
	public function search_orders(){
		$status=$this->get('status');
		if($status=="ALL"){
			$status='';
		}
		$this->logger->debug('merchant orders status is',array($status));
		$orders =$this->order->getMerchantOrdersByStatus($status,'product');
		$this->request->session('merchant_orders',$orders);
		$this->request->session('class','active');
		$this->request->session('status',$this->get('status'));
		//print_r($this->request->session('cash_coupon',$cashcoupon));
		if(true) {
			echo json_encode(array('success' => true, 'msg' => $this->bundle->message('Delivery address set up successfully!')));
		}
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Delivery address set up failed!')));
		}

	}

	/**
	 * @Clips\Model({"orderItem","order","customerProduct"})
	 * @Clips\Form("admin/merchant/deliver_goods")
	 * @Clips\Scss("admin/merchant/deliver_goods")
	 * @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	 * @Clips\Js("application/static/js/admin/merchant/deliver_goods.js")
	 */
	public function deliver_goods($order_id){
		$this->title('Order Details',true);
		$top_menus = array('订单编号','下单时间','支付方式','付款时间','订单状态');
		$menus=array('商品名称','商品图片','单价','数量','优惠信息','小计','有效期');
		$orders = $this->order->load($order_id);
		$orderItems = $this->orderitem->getOrderItemsByOid($order_id,'product');


		$totalPrice=0;
		for($i=0;$i<count($orderItems);$i++){
			$ss[] =  explode(",",$orderItems[$i]->path);
		}
		for($i=0;$i<count($orderItems);$i++){
			$orderItems[$i]->path = $ss[$i];
		}
		for($i=0;$i<count($orderItems);$i++){
			$totalprice = $orderItems[$i]->amount*$orderItems[$i]->price;
			$orderItems[$i]->totalprice = $totalprice;
			$totalPrice +=$totalprice;
		}
		$this->formData("admin/merchant/deliver_goods",$orders);
		return $this->render('admin/merchant/deliver_goods',array(
				'order_details'=>$orderItems,
				'menus'=>$menus,'top_menus'=>$top_menus,
				'orders'=>$orders,
				'totalPrice'=>$totalPrice,
				'type'=>'bestpay_coupon'
		));
//		return $this->render('admin/merchant/deliver_goods',array('order_details'=>$orderItems,'form_action'=>$form_action));
	}

	/**
	 * @Clips\Model({"merchant","order","orderItem"})
	 * @Clips\Form("admin/merchant/deliver_goods")
	 * @Clips\Scss("admin/merchant/deliver_goods")
	 * @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	 */
	public function deliver_goods_form(){
		$now = new \DateTime();
		$order_id = $this->post('id');
		if(isset($order_id)){
			$this->order->update((object)array(
					'id'=>$order_id,
					'status' =>'Assigned',
					'distribution_company'=>$this->post('distribution_company'),
					'distribution_phone'=>$this->post('distribution_phone'),
					'timestamp'=>$now->format('Y-m-d H:i:s')
			));
			echo "<script>alert('发货成功！');</script>";
			return $this->redirect('admin/merchant/orders',true);
		}
		return false;
	}

	/**
	 * @Clips\Model({"order"})
	 */
	public function merchant_cancel(){
		$ks = $this->order->cancel_order($this->post());
		if($ks){
			echo "<script>alert('操作成功！');</script>";
			return $this->redirect('admin/merchant/orders',true);
		}
		return false;

	}

	/**
	 * @Clips\Model({"orderItem","order","customerProduct","merchant"})
	 * @Clips\Form("admin/merchant/order_distribute")
	 * @Clips\Scss("admin/merchant/order_distribute")
	 * @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	 * @Clips\Js("application/static/js/admin/merchant/distribute.js")
	 */
	public function order_distribute($order_id){
		$top_menus = array('订单编号','下单时间','支付方式','付款时间','订单状态');
		$menus=array('商品名称','商品图片','单价','数量','优惠信息','小计','有效期');
		$orders = $this->order->load($order_id);
		$orderItems = $this->orderitem->getOrderItemsByOid($order_id,$type='product');
		$totalPrice=0;
		for($i=0;$i<count($orderItems);$i++){
			$ss[] =  explode(",",$orderItems[$i]->path);
		}
		for($i=0;$i<count($orderItems);$i++){
			$orderItems[$i]->path = $ss[$i];
		}
		for($i=0;$i<count($orderItems);$i++){
			$totalprice = $orderItems[$i]->amount*$orderItems[$i]->price;
			$orderItems[$i]->totalprice = $totalprice;
			$totalPrice +=$totalprice;
		}
		$merchants = $this->merchant->getMerchants();
		for($i=0;$i<count($merchants);$i++){
			$children_merchants[$i] = $merchants[$i]->name;
		}
		$args = array_merge(array('=请选择要分配的商家='),$children_merchants);
		$this->formData("admin/merchant/order_distribute",$orderItems);
		$p[] = new \Clips\Libraries\CommonOperator('orders.status', 'DELETE', '!=');
		$form_action = \Clips\site_url('admin/merchant/deliver_goods');
		return $this->render('admin/merchant/order_distribute',array(
				'order_details'=>$orderItems,
				'menus'=>$menus,'top_menus'=>$top_menus,
				'orders'=>$orders,
				'totalPrice'=>$totalPrice,
				'form_action'=>$form_action,
				'children_merchants'=>$args,
				'type'=>'bestpay_coupon'
		));
	}

	/**
	 * @Clips\Model({"order","orderItem","merchant"})
	 * @Clips\Form("admin/merchant/order_distribute")
	 * @Clips\Scss("admin/merchant/order_distribute")
	 * @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	 * @Clips\Js("application/static/js/admin/merchant/orders.js")
	 */
	public function order_distribute_form(){
		$order_id = $this->post('order_id');
		$merchants = $this->merchant->getMerchantsByName($this->post('merchant_name'));
		$now = new \DateTime();
		if(isset($order_id)){
			$this->order->update((object)array(
					'id'=>$order_id,
					'status' =>'Distributed',
					'merchant_id'=>$merchants->id,
					'timestamp'=>$now->format('Y-m-d H:i:s')
			));
			echo "<script>alert('分配成功！');</script>";
			return $this->redirect('admin/merchant/orders',true);
		}
		return false;
	}

	/**
	 * @Clips\Model({"merchant","orderItem","order","customerProduct"})
	 * @Clips\Scss("admin/merchant/order_details")
	 * @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	 */
	public function order_details($order_id){
		$this->title('Order Details',true);
		$top_menus = array('订单编号','下单时间','支付方式','付款时间','订单状态');
		$menus=array('商品名称','商品图片','单价','数量','优惠信息','小计','有效期');
		$orders = $this->order->load($order_id);
		$orderItems = $this->orderitem->getOrderItemsByOid($order_id,$type='product');
		$merchants = $this->merchant->load($orders->mid);
		$totalPrice=0;
		for($i=0;$i<count($orderItems);$i++){
			$ss[] =  explode(",",$orderItems[$i]->path);
		}
		for($i=0;$i<count($orderItems);$i++){
			$orderItems[$i]->path = $ss[$i];
		}
		for($i=0;$i<count($orderItems);$i++){
			$totalprice = $orderItems[$i]->amount*$orderItems[$i]->price;
			$orderItems[$i]->totalprice = $totalprice;
			$totalPrice +=$totalprice;
		}

		$customerProduct = $this->customerproduct->getCustomerProductByOID($orderItems[0]->item_id,'product');
		foreach ($customerProduct as $k=>$v) {
			$customerProduct[$k]->name = $orderItems[$k]->name;
			$customerProduct[$k]->path = $orderItems[$k]->path;
			$customerProduct[$k]->expire_date = $orderItems[$k]->expire_date;
			$customerProduct[$k]->totalprice = $customerProduct[$k]->price*$customerProduct[$k]->amount;
		}
		$place = $orders->place;
		return $this->render('admin/merchant/order_details',array(
				'order_details'=>$orderItems,
				'menus'=>$menus,'top_menus'=>$top_menus,
				'orders'=>$orders,
				'totalPrice'=>$totalPrice,
				'type'=>'bestpay_coupon',
				'merchants'=>$merchants,
				'place'=>$place
		));
	}
	/**
	 * @Clips\Model({"order","product","orderItem"})
	 * @Clips\Widgets\ListView("user_orders")
	 * @Clips\Widget({"selectboxit","grid", "image", "bootstrap", "yizhifu"})
	 * @Clips\Scss("user/order_details")
	 */
	public function deleteOrder($order_id){
		$ks = $this->order->deleteOrder($order_id);
		if($ks)
			echo json_encode(array('success'=>true, 'msg'=>$this->bundle->message('Order delete successfully!')));
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Order delete failed!')));
		}
	}
} 