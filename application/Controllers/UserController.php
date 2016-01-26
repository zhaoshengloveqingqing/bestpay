<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\BaseController;

/**
 * @Clips\MessageBundle(name="user")
 * @Clips\Widget({"html", "lang", "grid", "image", "bootstrap","navigation", "form","YMDselect", "yizhifu"})
 * @Clips\Context(key = 'test_data', value = 'navigation')	 * @Clips\Object('testData')
 */
class UserController extends BaseController {

	/**
	 * @Clips\Model({"users"})
	 * @Clips\Widgets\DataTable("user_index")
	 * @Clips\Scss("user/index")
	 * @Clips\Form('user/index')
	 */
	public function index() {
		$this->title('User List', true);
		return $this->render('user/index');
	}

	/**
	 * @Clips\Model({"user","product"})
	 * @Clips\Scss("user/my_coupon")
	 * @Clips\Widgets\ListView("home_index")
	 */
	public function my_coupon($status='cash_coupon',$page_no=1) {
		$this->title('My Discount Coupon', true);
		$pagesize = 10;
		$offset = ($page_no-1)*$pagesize;
		$user_id = $this->user->getCurrentUserId();
		if($status == 'discount_coupon'){
			$url = 'user/my_coupon/discount_coupon/';
		}elseif($status == 'general_coupon'){
			$url = 'user/my_coupon/general_coupon/';
		}else{
			$url = 'user/my_coupon/cash_coupon/';
		}
		$total = $this->product->getCashCouponCount($user_id,$status);
		$cashcoupon = $this->product->getCashCoupon($user_id,$status,$offset,$pagesize);
		$pagestr = $this->pages($total,$pagesize,$page_no,$url);
		return $this->render('user/my_coupon',array('cash_coupons'=>$cashcoupon,'status'=>$status,'pagestr'=>$pagestr));
	}

	/**
	 * @Clips\Model({"user","product"})
	 * @Clips\Js("application/static/js/user/my_coupon.js")
	 */
	public function search_coupons(){
		$this->get('status');
		$user_id = $this->user->getCurrentUserId();
		$cashcoupon =$this->product->getCashCoupon($user_id,$this->get('status'));
		$this->request->session('cash_coupon',$cashcoupon);
		$this->request->session('class','active');
		$this->request->session('my_coupon_status',$this->get('status'));
		//print_r($this->request->session('cash_coupon',$cashcoupon));
		if(true) {
			echo json_encode(array('success' => true, 'msg' => $this->bundle->message('Delivery address set up successfully!')));
		}
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Delivery address set up failed!')));
		}

	}

	/**
	 * @Clips\Model({"user","customer","customerProduct","cart","order","paymentmethod","orderItem"})
	 * @Clips\Widgets\ListView("home_index")
	 * @Clips\Scss("user/bestpay_coupon")
	 * @Clips\Js("application/static/js/user/bestpay_coupon.js")
	 * @Clips\Form('user/bestpay_coupon')
	 */
	public function bestpay_coupon($status='all',$page_no=1) {
		$this->title('My Coupon', true);
		$pagesize = 10;
		$offset = ($page_no-1)*$pagesize;
		if($this->post()!=null){
			$this->order->cancel_order($this->post());
		}
		$user_id = $this->user->getCurrentUserId();

		if($status == 'nopay'){
			$url = 'user/bestpay_coupon/nopay/';
		}elseif($status == 'distributed'){
			$url = 'user/bestpay_coupon/distributed/';
		}elseif($status == 'pay'){
			$url = 'user/bestpay_coupon/pay/';
		}elseif($status == 'use'){
			$url = 'user/bestpay_coupon/use/';
		}elseif($status == 'expired'){
			$url = 'user/bestpay_coupon/expired/';
		}else{
			$url = 'user/bestpay_coupon/all/';
		}
//		$total = $this->order->getOrdersCount($user_id,$status,'bestpay_coupon');
//		$orders = $this->order->getOrdersByStatus($user_id,$status,$offset,$pagesize,'bestpay_coupon');
		$total = $this->order->getCouponsCount($user_id,$status);
		$orders = $this->order->getCouponsByStatus($user_id,$status,$offset,$pagesize);
		$pagestr = $this->pages($total,$pagesize,$page_no,$url);

		$orderItems = $this->orderitem->getOrderItemByCid($user_id);
		for($i=0;$i<count($orderItems);$i++){
			$ss[] =  explode(",",$orderItems[$i]->path);
		}
		for($i=0;$i<count($orderItems);$i++){
			$orderItems[$i]->path = $ss[$i];
		}
		$ko=array();
		$ks=array();
		$pt=array();
		foreach ($orders as $item) {
			if(!in_array($item->id, $ko)) {
				$ko[] = $item->id;
			}
			$pt = $ko;

		}
		foreach ($pt as $ko) {
			foreach ($orderItems as $goods) {
				if ($goods->order_id == $ko) {
					$ks[$ko][] = $goods;
					unset($goods);
				}
			}
		}
//		var_dump($ks);die;
		$merchants_count = array_intersect(array_keys($ks),$pt);
		$merchant_names = array();
		foreach ($orders as $item) {
			in_array($item->merchant_name,$merchant_names)? function () use(&$item){unset($item);}:$merchant_names[]->merchant_name = $item->merchant_name;

		}

		$reason = array('收到商品破损','商品错发/漏发','收到商品与描述不符','商品质量/保质期问题','其他原因.....');
		$cancel_reason = array_merge(array('=请选择取消理由='),$reason);
		$uid = $this->user->getCurrentUserId();
		$p[] = array('users.id' => $uid,'product_photos.is_primary'=>'1');
		$p[] = new \Clips\Libraries\CommonOperator('orders.status', 'DELETE', '!=');
		$this->request->session('user_orders', $p);
		$form_action = \Clips\site_url('user/bestpay_coupon');
		foreach ($ks as $k=>$v) {
			$total_price = 0;
			foreach ($v as $k1=>$v1) {
				$ks[$k][$k1]->code = $this->customerproduct->getCode($v1->id);
				$total_price += $v1->price * $v1->amount;
			}
			$ks[$k]['total_price']=$total_price;
		}
//		var_dump($ks);die;
		return $this->render('user/bestpay_coupon',array('status'=>$status,
				"orders"=>$ks,"merchants"=>$merchants_count,
				"merchant_names"=>$merchant_names,'cancel_reason'=>$cancel_reason,
				'form_action'=>$form_action,'pagestr'=>$pagestr));
	}

	/**
	 * @Clips\Model({"user","customer","customerProduct","cart","order","paymentmethod","orderItem"})
	 */
	public function search_coupon(){
		$user_id = $this->user->getCurrentUserId();
		$status=$this->get('status');
		if($status=="ALL"){
			$status='';
		}

		$orders =$this->order->getOrdersByGetStatus($user_id,$status);
		$this->logger->debug('user orders status is',array($orders));
		$this->request->session('coupon_data',$orders);
		$this->request->session('class','active');
		$this->request->session('coupon_status',$this->get('status'));
		//print_r($this->request->session('cash_coupon',$cashcoupon));
		if(true) {
			echo json_encode(array('success' => true, 'msg' => $this->bundle->message('Delivery address set up successfully!')));
		}
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Delivery address set up failed!')));
		}

	}
	/**
	 * @Clips\Model({"user"})
	 * @Clips\Scss("user/user_info")
	 * @Clips\Form('user/user_info')
	 * @Clips\Js("application/static/js/user/user_info.js")
	 */
	public function user_info() {
		$this->title('Personal Information', true);
		$user_infos = $this->user->get_userinfo($this->request->session('token'));
		$this->formData("user/user_info",$user_infos);
		$user_id = $this->user->getCurrentUserId();
		$birthday = array(substr($user_infos->birthday,0,4),substr($user_infos->birthday,5,2),substr($user_infos->birthday,8,10));
		return $this->render('user/user_info',array('user_infos'=>$user_infos,'birthday'=>$birthday));


	}

	/**
	 * @Clips\Model({"user"})
	 */
	public function update_userinfo(){
		$this->logger->debug('KO DATA IS',array($this->post()));
		$id=$this->user->update_userinfo($this->post(),$this->request->session('token'));
		if($id) {
			echo json_encode(array('success' => true, 'msg' => $this->bundle->message('User information update successfully!')));
		}
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('User information update failed!')));
		}
	}

	/**
	 * @Clips\Model({"user","customer"})
	 * @Clips\Form('user/account')
	 * @Clips\Scss("user/account")
	 * @Clips\Widget({"qrcode","jqzom","slider"})
	 * @Clips\Js("application/static/js/user/account.js")
	 */
	public function account() {
		$this->title('Account Setting', true);
		$request = \Clips\context('request');
		$user_infos = $this->user->get_userinfo($request->session('token'));
		$this->formData("user/account",$user_infos);
		$url ='http://user.pinet.co/api/get_code';
		$token=$this->request->session('token');
		return $this->render('user/account',array('user_infos'=>$user_infos,'url'=>$url,'token'=>$token));
	}
	/**
	 * @Clips\Model({"user"})
	 * @Clips\Library({"encryptor", "curl"})
	 */
	public function account_submit(){
		$back=$this->user->update_account($this->post('token'),$this->post('mobile'));
		if(isset($back)){
			return $this->redirect('user/account',true);
		}
		return false;
	}

	/**
	 * @Clips\Model({"user","customer"})
	 * @Clips\Form('user/account')
	 * @Clips\Scss("user/account")
	 * @Clips\Js("application/static/js/user/account.js")
	 */
	public function account_edit(){

		$id=$this->customer->update_account($this->post());
		if($id) {
			echo json_encode(array('success' => true, 'msg' => $this->bundle->message('User information update successfully!')));
		}
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('User information update failed!')));
		}
	}
	/**
	 * @Clips\Model({"paymentMethod","user","cart","order","product","customer","merchant", "place"})
	 * @Clips\Form('user/my_address')
	 * @Clips\Scss("user/my_address")
	 * @Clips\Js({"application/static/js/user/my_address.js"})
	 */
	public function my_address() {
		$this->title('Delivery Address', true);
		$user_id = $this->user->getCurrentUserId();
		$address = $this->user->deliveryAddressByUid($user_id);
		$cid = $this->request->session('cid');
		for($i=0;$i<count($address);$i++){
			$address[$i]->count=count($address);
			$province [$i]=array($address[$i]->province);
			$city [$i]=array($address[$i]->city);
			$area [$i]=array($address[$i]->area);
			$a[$i] = $this->place->getElementName($province[$i])->name;
			$b[$i] = $this->place->getElementName($city[$i])->name;
			$c[$i] = $this->place->getElementName($area[$i])->name;
		}
		for($i=0;$i<count($a);$i++){
			$place[$i]=$a[$i].$b[$i].$c[$i];
			$address[$i]->place =$place[$i];
		}
		$data = $this->request->session('c_data');
		if($address==null||$this->request->session('cid')!=null){
			$this->request->session('cid',null);
			$this->request->session('c_data',null);
		}
		if(isset($data)){
			$res = array($this->request->session('c_data')->province,$this->request->session('c_data')->city,$this->request->session('c_data')->area);
			for($i=0;$i<count($res);$i++){
				$pt[$i]= $this->place->getElementName($res[$i])->name;
			}

			$place = $pt[0].'省'.$pt[1].$pt[2];
			$this->formData("user/my_address",$data);
//			$this->formData('user/my_address', (object)array('province'=> $data->province, 'city' => $data->city,'data'=>$data));
		}else{

			$this->formData('user/my_address', array('province'=> 16, 'city' => 221));
		}
		$this->logger->debug('testing data is',array($this->post()));
		$checkbox=$data->default_address;
		return $this->render('user/my_address',array('checkbox'=>$checkbox,'place'=>$place,'cid'=>$cid,'address'=>$address, 'province' => $this->place->listProvince()));
	}

	/**
	 * @Clips\Model({"user","customer"})
	 */
	public function getCid(){
		$this->post();
		$cid=$this->request->session('cid',$this->post('id'));
		$data = $this->user->getMyAddressByCid($cid);
		$this->request->session('c_data',$data);
		if(true) {
			echo json_encode(array('success' => true, 'msg' => $this->bundle->message('Delivery address set up successfully!')));
		}
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Delivery address set up failed!')));
		}
	}

	/**
	 * @Clips\Model({"users"})
	 * @Clips\Form('user/my_address')
	 * @Clips\Scss("user/my_address")
	 */
	public function my_address_form() {
		$this->title('User List', true);
		return $this->render('user/my_address',array('form_action'=>\Clips\site_url('order/confirm')));
	}

	public function show(){
		return $this->render('user/show');
	}

	/**
	 * @Clips\Model({"user","customer","customerProduct","cart","order","paymentmethod","orderItem"})
	 * @Clips\Widgets\ListView("user_orders")
	 * @Clips\Js("application/static/js/user/orders.js")
	 * @Clips\Scss("user/orders")
	 * @Clips\Form('user/order');
	 */
	public function orders($status='all',$page_no=1)
	{
		$pagesize = 10;
		$offset = ($page_no-1)*$pagesize;

		$this->logger->debug('cancel order id is ',array($this->get('id')));
		$user_id = $this->user->getCurrentUserId();
		if($status == 'nopay'){
			$url = 'user/orders/nopay/';
		}elseif($status == 'Assigned'){
			$url = 'user/orders/Assigned/';
		}elseif($status == 'received'){
			$url = 'user/orders/received/';
		}else{
			$url = 'user/orders/all/';
		}
		$total = $this->order->getOrdersCount($user_id,$status,'product');
		$orders = $this->order->getOrdersByStatus($user_id,$status,$offset,$pagesize,'product');

//		var_dump($orders);die;
		$pagestr = $this->pages($total,$pagesize,$page_no,$url);
		$orderItems = $this->orderitem->getOrderItemByUid($user_id,'product');

		for($i=0;$i<count($orderItems);$i++){
			$ss[] =  explode(",",$orderItems[$i]->path);
		}
		for($i=0;$i<count($orderItems);$i++){
			$orderItems[$i]->path = $ss[$i];
		}
		$arr = array();
		$marry = array();
		$merchants = array();

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

		$reason = array('我不想买了','信息填写错误，重新拍','卖家缺货','同城见面交易','付款遇到问题','拍错了','其他原因');
		$cancel_reason = array_merge(array('=请选择取消理由='),$reason);
		unset($tmp);
		$this->title('My Order Page',true);
		$uid = $this->user->getCurrentUserId();
		$p[] = array('users.id' => $uid,'product_photos.is_primary'=>'1');
		$p[] = new \Clips\Libraries\CommonOperator('orders.status', 'DELETE', '!=');
		$this->request->session('user_orders', $p);
		$form_action = \Clips\site_url('user/cancel_order');

		foreach ($arr as $k=>$v) {
			$total_price = 0;
			foreach ($v as $k1=>$v2) {
				$total_price += $v2->price * $v2->amount;
			}
			$arr[$k]['total_price']=$total_price;
		}
		$merchant_names = array();
		foreach ($orders as $item) {
			in_array($item->merchant_name,$merchant_names)? function () use(&$item){unset($item);}:$merchant_names[]['merchant_name'] = $item->merchant_name;

		}
//		var_dump($item);die;
		return $this->render('user/orders',array("status"=>$status,
				"orders"=>$arr,"merchants"=>$merchants,'merchant_names'=>$merchant_names,
				'cancel_reason'=>$cancel_reason,'form_action'=>$form_action,'pagestr'=>$pagestr));
	}

	/**
	 * @Clips\Model({"user","customer","customerProduct","cart","order","paymentmethod","orderItem"})
	 */
	public function search_orders(){
		$user_id = $this->user->getCurrentUserId();
		$status=$this->get('status');
		if($status=="ALL"){
			$status='';
		}

		$orders =$this->order->getOrdersByUid($user_id,$status);
		$this->logger->debug('user orders status is',array($orders));
		$this->request->session('orders',$orders);
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
	 * @Clips\Model({"orderItem","order","orderItem","customerProduct"})
	 * @Clips\Scss("user/order_details")
	 */
	public function bestpay_coupon_details($order_id){
		$this->title('Order Details',true);
		$top_menus = array('订单编号','下单时间','支付方式','付款时间','订单状态');
		$menus=array('商品名称','商品图片','单价','数量','优惠信息','验券码','有效期','状态');
		$orders = $this->order->load($order_id);
		$orderItems = $this->orderitem->getOrderItemsByOid($order_id,$type="bestpay_coupon");
		$totalPrice=0;

		for($i=0;$i<count($orderItems);$i++){
			$totalprice = $orderItems[$i]->amount*$orderItems[$i]->price;
			$orderItems[$i]->totalprice = $totalprice;
			$totalPrice +=$totalprice;
		}

		$arr = array();
		foreach ($orderItems as $v) {
			$arr[] = $this->customerproduct->getCustomerProductByOID($v->item_id,$type="bestpay_coupon");
		}

		$customerProduct = array();
		foreach ($arr as $v) {
			foreach ($v as $v1) {
				$customerProduct[] = $v1;
			}
		}

		foreach ($customerProduct as $k=>$v) {
			$item = $this->orderitem->getOrderItemByItemID($v->item_id)[0];
			$customerProduct[$k]->name = $item->name;
			$customerProduct[$k]->path[0] = $item->path;
			$customerProduct[$k]->expire_date = $item->expire_date;
			$customerProduct[$k]->amount = 1;
			if($orders->status == 'NOPAY') {
				$customerProduct[$k]->code = '无';
			}

		}
//		var_dump($customerProduct);die;
		return $this->render('user/order_details',array(
				'order_details'=>$customerProduct,
				'menus'=>$menus,'top_menus'=>$top_menus,
				'orders'=>$orders,
				'totalPrice'=>$totalPrice,
				'type'=>'bestpay_coupon'
		));
	}

	/**
	 * @Clips\Model({"orderItem","order","merchant"})
	 * @Clips\Scss("user/order_details")
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
		$place = $orders->place;
		return $this->render('user/order_details',array(
				'order_details'=>$orderItems,
				'menus'=>$menus,
				'top_menus'=>$top_menus,
				'orders'=>$orders,
				'totalPrice'=>$totalPrice,
				'type'=>'product',
				'merchants'=>$merchants,
				'place'=>$place
		));
	}

	/**
	 * @Clips\Widgets\DataTable("user_product")
	 */
	public function products(){
		return $this->render('user/products');
	}

	/**
	 * @Clips\Model({"user","customer","cart"});
	 * @Clips\Form('user/register');
	 * @Clips\Scss("user/register")
	 * @Clips\Widget({"datepicker"})
	 * @Clips\Library({"encryptor", "curl"})
	 * @Clips\Js("application/static/js/user/register.js")
	 */
	public function register(){
		$this->title('User Complete Register',true);
		//$bs = $this->request->breadscrumb();
		$sex = array('n'=>$this->bundle->message('Other'), 'm'=>$this->bundle->message('Male'), 'f'=>$this->bundle->message('Female'));
		$this->request->session('token',$this->get('token'));
		if($this->get('token')) {
			$token = json_decode($this->encryptor->publicDecrypt($this->get('token')));
			$users = $this->user->load($token->uid);
			if (isset($token->uid)) {
				if (isset($users->id)) {
					$this->user->isRegister($this->get('token'));
					$backurl = $this->request->session('buy_callback');
					if($backurl){
						return $this->redirect($backurl);
					}else{
						return $this->redirect(\Clips\site_url('user/orders'));
					}
				} else {
					if (!isset($users->id)) {
						$this->formData('user/register',$token);
						return $this->render('user/register',array('sex'=>$sex));
					}
				}
			}
		}
		//need to adjust user if in system, in then forward to user/index, not if, to register page
		return $this->redirect('http://user.pinet.co/api/login?appid=4000&template=user&callback='.\Clips\site_url('user/register', true));
	}
	/**
	 * @Clips\Model({"user","customer"});
	 * @Clips\Form('user/register');
	 * @Clips\Scss("user/register")
	 * @Clips\Widget({"datepicker"})
	 * @Clips\Library({"curl"})
	 * @Clips\Js("application/static/js/user/register.js")
	 */
	public function register_form(){
		if($this->post('password') != $this->post('password_confirm')){
			$this->error('password and password_confirm is different!');
			return;
		}
		if($this->user->finishRegister($this->request->post(),$this->get('token'))){
			return $this->redirect(\Clips\site_url('user/orders'));
		}
		return $this->redirect('user/register',true);
	}

	/**
	 * @Clips\Model({"user","cart"});
	 */
	public function logout(){
		$this->request->session()->destroy();
		return $this->redirect('http://user.pinet.co/api/logout?appid=4000&template=user&callback='.\Clips\site_url('home/index', true));
	}

	/**
	 * @Clips\Model({"order"});
	 */
	public function cancel_order(){
		$this->logger->debug('show the coupon data is ', array());
		$id = $this->order->cancel_order($this->post());

		return $this->redirect('user/orders',true);
	}

	/**
	 * @Clips\Model({"users","customer"})
	 */
	public function add_address() {
		$this->title('User List', true);
		$pt = $this->request->session('product_data');
		$this->request->session('product_data',$pt);
		if($this->post('id')){
			$id=$this->customer->edit_Address($this->request->post());
			if($id) {
				echo json_encode(array('success' => true, 'msg' => $this->bundle->message('Delivery address set up successfully!')));
			}
			else{
				echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Delivery address set up failed!')));
			}
		}else{
			$id=$this->customer->add_Address($this->request->post());
			if($id) {
				echo json_encode(array('success' => true, 'msg' => $this->bundle->message('Delivery address set up successfully!')));
			}
			else{
				echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Delivery address set up failed!')));
			}
		}
	}
	/**
	 * @Clips\Model({"order"});
	 */
	public function confirm_order($id){
		$this->order->confirm_order($this->post());
		if($id) {
			echo json_encode(array('success' => true, 'msg' => $this->bundle->message('Order confirm successfully!')));
		}
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Order confirm failed!')));
		}
	}


}
