<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table orders
 *
 * @author Jack
 * @version 1.0
 * @date Sun Mar 15 12:08:08 2015
 *
 * @Clips\Model({"merchant","cart","order","product","orderItem","customerProduct","customer","merchantProduct","productPhoto","user","place"})
 */
class OrderModel extends DBModel {

	public function get_shop_sn() {
		mt_srand((double) microtime() * 1000000);
		$rand_id = mt_rand(1, 99999);
		return $rand_id+100000;
	}

	public function addOrder($post,$uid,$customer){
		$totalPrice=$post['discount_price'][0]*$post['number'][0];
		$now = new \DateTime();
		$ordid = "00" . date('YmdHis'); # Order ID
		$place='';
		if($customer!=null){
			$province = $this->place->getElementName($customer->province)->name;
			$city = $this->place->getElementName($customer->city)->name;
			$area = $this->place->getElementName($customer->area)->name;
			$place = $province.$city.$area;
		}
		$merchants = $this->merchant->getMerchantsIDByProductID($post['product_id']);

		$this->jump_bestpay($ordid,$totalPrice);

		if($place!=null){
			$data['place']=$place;
			$data['consignee_mobile']=$customer->mobile;
			$data['consignee_name']=$customer->consignee;
			$data['consignee_address']=$customer->delivery_address;
		}
		$data['name']=$post['name'][0];
		$data['uid']=$uid;
		$data['distribution_way']=$post['distribution_way'];
		$data['mid'] = $merchants[0]->id;
		$data['order_number']=$ordid;
		$data['status']='NOPAY';
		$data['payment_id']=$post['payment_id'];
		$data['timestamp']='';
		$data['create_date']=$now->format('Y-m-d H:i:s');
		$orderID=$this->insert($data);
		if(!$orderID){
			return $this->error('This OrderId is Null');
		}
		return $orderID;
	}

	public function updateOrder($order_id){
		$order = $this->load($order_id);
		$order_details =  $this->orderitem->getOrderItemsByOrderID($order_id);

		$totalPrice=0;
		foreach($order_details as $v){
			$price=$v->price*$v->amount;
			$totalPrice+=$price;

		}

		$key='21B039458D76AAD8C0C06203DEFADAC9B948BB19633EB3C2';
		$merchantid='03340103030956000';
		if ($merchantid!=null)
		{
			//MERCHANTID=03340103030956000&ORDERSEQ=00020141119094450111&ORDERDATE=20141119&ORDERAMOUNT=2000&KEY=21B039458D76AAD8C0C06203DEFADAC9B948BB19633EB3C2
			$order_amount=222;
			if($p=1) {
				$merid='03340103030956000';
				$ordid = $order->order_number; # Order ID
				//$ordid = '0020141119113004'; # Order ID
				$attachamount = "0"; # Payment Version
				$productamount= intval($totalPrice)*100;
				$orderamount =$attachamount+$productamount; # Amount
				$orderdate=date('YmdHis');
				//$orderdate='20141119112328';
				//md5 mac
				$macmd5="MERCHANTID=$merchantid&ORDERSEQ=$ordid&ORDERDATE=$orderdate&ORDERAMOUNT=$orderamount&KEY=$key";
				//$mac='c612179b6364333aa91afcba75c2479e';
				$mac=md5($macmd5);

				$curtype='RMB';
				$orderreqtranseq="99" . date('YmdHis'); # Order ID
				$encodetype = "1"; # Currency Type, Use CNY
				$transdate = date('Ymd'); # Order Date
				$busicode = "0001"; # Transaction type, Consume

				$pagereturl = "http://hict.cc/order/payback"; # Feedback Url
				$bgreturl = "http://hict.cc/order/payback";
				$productdesc='Iphone6 plus';
				?>
				<html>
				<body onload="document.getElementById('form').submit();">
				<form id="form" action="https://webpaywg.bestpay.com.cn/payWeb.do" method="post">
					<input type=hidden name="MERCHANTID" value="<?php echo $merid; ?>"/>
					<input type=hidden name="ORDERSEQ" value="<?php echo $ordid; ?>"/>
					<input type=hidden name="ORDERREQTRANSEQ" value="<?php echo $orderreqtranseq; ?>"/>
					<input type=hidden name="ORDERDATE" value="<?php echo $orderdate; ?>"/>
					<input type=hidden name="ORDERAMOUNT" value="<?php echo $orderamount; ?>"/>
					<input type=hidden name="PRODUCTAMOUNT" value="<?php echo $productamount; ?>"/>
					<input type=hidden name="ATTACHAMOUNT" value="<?php echo $attachamount; ?>"/>

					<input type=hidden name="CURTYPE" value="<?php echo $curtype; ?>"/>
					<input type=hidden name="ENCODETYPE" value="<?php echo $encodetype; ?>"/>
					<input type=hidden name="MERCHANTURL" value="<?php echo $pagereturl; ?>"/>
					<input type=hidden name="BACKMERCHANTURL" value="<?php echo $bgreturl; ?>"/>
					<input type=hidden name="BUSICODE" value="<?php echo $busicode; ?>"/>
					<input type=hidden name="PRODUCTDESC" value="<?php echo $productdesc; ?>"/>
					<input type=hidden name="MAC" value="<?php echo $mac; ?>"/>
				</form>
				</body>
				</html>
			<?php
			}
			else {
				die('Failed');
			}
			exit();
		}
		/*$now = new \DateTime();
		if(isset($order_id)){
			return $this->update((object)array(
					'id' =>$order_id,
					'status' =>'ACTIVE',
					'timestamp' =>$now->format('Y-m-d H:i:s')
			));
		}
		return false;*/
	}

	public function orderInfo($order_num){
		if(!$order_num)
			return null;
		return $this->one(array(
				'order_number' => $order_num
		));
	}

	public function updateOrderByBack(){
		$key='21B039458D76AAD8C0C06203DEFADAC9B948BB19633EB3C2';
		$merchantid='03340103030956000';
		if($_POST['UPTRANSEQ']!=null){
			$UPTRANSEQ=$_POST['UPTRANSEQ'];
			$TRANDATE=$_POST['TRANDATE'];
			$RETNCODE=$_POST['RETNCODE'];
			$RETNINFO=$_POST['RETNINFO'];
			$ORDERREQTRANSEQ=$_POST['ORDERREQTRANSEQ'];
			$ORDERSEQ=$_POST['ORDERSEQ'];
			$ORDERAMOUNT=$_POST['ORDERAMOUNT'];
			$PRODUCTAMOUNT=$_POST['PRODUCTAMOUNT'];
			$ATTACHAMOUNT=$_POST['ATTACHAMOUNT'];
			$CURTYPE=$_POST['CURTYPE'];
			$ENCODETYPE=$_POST['ENCODETYPE'];
			$BANKID=$_POST['BANKID'];
			$SIGN=$_POST['SIGN'];
			//compare sign
			$originalsign="UPTRANSEQ=$UPTRANSEQ&MERCHANTID=$merchantid&ORDERID=$ORDERSEQ&PAYMENT=$ORDERAMOUNT&RETNCODE=$RETNCODE&RETNINFO=$RETNINFO&PAYDATE=$TRANDATE&KEY=$key";
			$md5_originalsign=strtoupper(md5($originalsign));
			//$sub_originalsign=str_replace(array("\t","\n","\r"),'',stripcslashes($md5_originalsign));
			if($SIGN==$md5_originalsign){
				$now = new \DateTime();
				$request = \Clips\context('request');
				$orders=$request->session('orders_ID');

				if(isset($orders)){
					foreach($orders as $v) {
						$this->update((object)array(
								'id' => $v,
								'status' => 'PAY',
								'timestamp' => $now->format('Y-m-d H:i:s')
						));
					}
					return $orders;
				}
				echo  "UPTRANSEQ_".$UPTRANSEQ;
			}
			else{
				echo "error";
			}

		}
	}

	public function gotoPay($post,$payment_id){
		$radio=array('radio'=>null);
		$post=array_merge($radio,$post);
		$customers='';
		if($post['radio']!=null){
			$customers = $this->customer->one(array(
					'id' => $post['radio']
			));
		}

		if($customers!=null){
			$province = $this->place->getElementName($customers->province)->name;
			$city = $this->place->getElementName($customers->city)->name;
			$area = $this->place->getElementName($customers->area)->name;
			$place = $province.$city.$area;
		}



		$request = \Clips\context('request');
		$uid = $request->session('user_id');
		if($request->session('is_cart')=='cart_buy'){
			if($post){
				foreach($post['product_id'] as $k=>$v){
					$products[$k]=$this->product->load($v);

				}
				foreach($post['number'] as $k=>$v){
					$amount[$k]=$v;

				}

				for($i=0;$i<count($products);$i++){
					$this->product->updateProduct($products[$i],$products[$i]->id,$amount[$i]);
				}
			}

			$request->session('is_cart','');
			$now = new \DateTime();
			$user_id = $this->user->getCurrentUserId();
			$count = count($post['product_id']);
			foreach ($post['product_id'] as $key=>$value) {
				$product[] = $this->product->getProductsByCart($value);
			}


			for($i=0;$i<$count;$i++){
				$product[$i]->amount=$post['number'][$i];
			}

			$merchants=array();
			$arr=array();
			foreach($product as $item){
				in_array($item->merchant_id,$merchants)||$merchants[]=$item->merchant_id;
			}
			foreach($merchants as $merchant){
				foreach ($product as $goods) {
					if($goods->merchant_id==$merchant){
						$arr[$merchant][]=$goods;
//						unset($goods);
					}
				}
			}
			$totalPrice=0;
			foreach($product as $v){
				$price=$v->price*$v->amount;
				$totalPrice+=$price;

			}
			$ordersNum = count($arr);
			$save=[];

			foreach($arr as $key =>$merchantGoods){
				$ordid =str_replace('m_','',$key) . date('YmdHis'); # Order ID
				foreach($merchantGoods as $v){
					if($v->category_id=='2'){
						$data['c_status'] = 'NOPAY';
					}
				}
				$this->jump_bestpay($ordid,$totalPrice);
				$ordid =str_replace('m_','',$key) . date('YmdHis'); # Order ID
				$data['place'] = $place;
				$data['uid'] = $uid;
				$data['name'] =str_replace('m_','',$key);
				$data['order_number'] = $ordid;
				$data['status'] = 'NOPAY';
				$data['distribution_way']=$post['distribution_way'];
				$data['consignee_mobile']=$customers->mobile;
				$data['consignee_name']=$customers->consignee;
				$data['consignee_address']=$customers->delivery_address;
				$data['payment_id'] = '1';
				$data['mid'] = str_replace('m_','',$key);
				$data['timestamp'] = '';
				$data['create_date'] = $now->format('Y-m-d H:i:s');
				$orderID = $this->insert($data);
				$save[]=$orderID;
				$request->session('is_cart','null');
				foreach($merchantGoods as $k =>$v){
					//插入订单详细表
					$res['product_id'] = $v->product_id;
					$res['order_id'] = $orderID;
					$res['uid'] = $user_id;
					$res['amount'] = $v->amount;
					$res['price'] = $v->discount_price;
					$res['timestamp'] = '';
					$res['create_date'] = $now->format('Y-m-d H:i:s');
					$orderItemID = $this->orderitem->insert($res);
					$orders = $this->order->load($orderID);
					$customer = $this->customer->getCustomer($user_id);

						for($i=0;$i<$v->amount;$i++){
							$this->customerproduct->customerProduct($v->product_id,$customer->id,$orders->create_date,$orderItemID);
						}

					$this->merchantproduct->merchantProduct($v->product_id,$orders->mid);
					if(!$orderItemID){
						$this->error('This orderItemID is Null');
					}
					$carts[]= $this->cart->getCartsByProductID($v->product_id);
					foreach($carts as $cart){
						foreach($cart as $value){

						}
					}
//					$this->cart->delete($value->id);
				}
			}
			$request->session('orders_ID',$save);
			exit();
			return $save;
		}

		$post['payment_id'] = $payment_id;

		if(!$post['payment_id']){
			return $this->error('This Payment_ID is null');
		}

		if(isset($uid)){
			$orderID = $this->addOrder($post,$uid,$customers);
		}else{
			$this->error('This User_id is Null');
		}
		if(!$orderID){
			$this->error('This OrderID is Null');
		}

		$orders = $this->order->load($orderID);
		$customer = $this->customer->getCustomer($uid);
		$this->merchantproduct->merchantProduct($post['product_id'][0],$orders->mid);
		$orderItemID=$this->orderitem->addOrderItem($post,$orderID,$uid);
		$amount = $post['number'][0];
		if($amount>1) {
			for($i=0;$i<$amount;$i++){
				$this->customerproduct->customerProduct($post['product_id'][0],$customer->id,$orders->create_date,$orderItemID);
			}
		}else{
			$this->customerproduct->customerProduct($post['product_id'][0],$customer->id,$orders->create_date,$orderItemID);
		}

		if(!$orderItemID){
			$this->error('This orderItemID is Null');
		}
		$amount = $post['number'][0];
		$id = $post['product_id'][0];
		$product = $this->product->load($id);
		if(isset($id)){
			$this->product->updateProduct($product,$id,$amount);
			$orders = $this->load($orderID);
			if($orders->status=='PAY'){
				return $orderID;
			}
			$request->session('orders_ID',$orderID);
			exit();
		}
		return false;

	}

	public function getProductByID($product_id){
		$request = \Clips\context('request');
		$product = $this->product->load($product_id);
		$amount = $request->session('post_number');
		$product_photos = $this->productphoto->getProductPhotos($product_id);
		$product->path = $product_photos[0]->path;
		$product->totalPrice =  $product->discount_price * $amount;
		$product->number = '4';
		$product->price = $product->discount_price;
		$product->product_id = $product->id;
		return $product;
	}

	public function getProductByConfirm($post,$payment_id){
		if($post){


			foreach ($post['amount'] as $key=>$value) {
				$amount[] = $value;
			}

			foreach ($post[product_id] as $key=>$value)
			{
				$product[] = $this->product->getProductsByCart($value);
			}

			$arrs = array_merge($product,(object)$amount);
			return $product;
		}
	}

	public function getProductWhenBuy($post){
		$id = $post['id'];
		if(!$id) {
			\Clips\error('Can\'t find product based on ID' . $id . '!', 'Not Found');
			return;
		}
		$amount = (integer) $post['number'];
		$product = $this->product->load($id);
		if($product->amount < $amount){
			return	'Product Amount Not Enough';
		}
		if($amount < 0){
			return	'Product Amount Not Enough';
		}
		$product_photos = $this->productphoto->getProductPhotos($id);
		$product->path = $product_photos[0]->path;
		$product->totalPrice =  $product->price * $amount;
		$product->number = $amount;
		return $product;
	}

	public function deleteOrder($order_id,$type){
		if($order_id){
			if($type=='product') {
				return $this->order->update((object)array(
						'id' =>$order_id,
						'status' =>'DELETE'
				));
			}else{
				return $this->order->update((object)array(
						'id' =>$order_id,
						'c_status' =>'DELETE'
				));
			}
		}

		$orderItems = $this->orderitem->getOrderItemByOrderID($order_id);
		$products = $this->product->load($orderItems->product_id);
		if($orderItems){
			$ks = $this->product->update((object)array(
					'id' =>$orderItems->product_id,
					'amount' =>$products->amount+$orderItems->amount
			));
		}
	}

	public function jump_bestpay($ordid,$totalPrice){
		$key='21B039458D76AAD8C0C06203DEFADAC9B948BB19633EB3C2';
		$merchantid='03340103030956000';
		if ($merchantid!=null)
		{
			//MERCHANTID=03340103030956000&ORDERSEQ=00020141119094450111&ORDERDATE=20141119&ORDERAMOUNT=2000&KEY=21B039458D76AAD8C0C06203DEFADAC9B948BB19633EB3C2
			$order_amount=222;
			if($p=1) {
				$merid='03340103030956000';
				$ordid = $ordid; # Order ID
				//$ordid = '0020141119113004'; # Order ID
				$attachamount = '0'; # Payment Version
				$productamount=intval($totalPrice*100);
				$orderamount =$attachamount+intval($productamount); # Amount
				$orderdate=date('YmdHis');
				//$orderdate='20141119112328';
				//md5 mac
				$macmd5="MERCHANTID=$merchantid&ORDERSEQ=$ordid&ORDERDATE=$orderdate&ORDERAMOUNT=$orderamount&KEY=$key";
				//$mac='c612179b6364333aa91afcba75c2479e';
				$mac=md5($macmd5);

				$curtype='RMB';
				$orderreqtranseq="99" . date('YmdHis'); # Order ID
				$encodetype = "1"; # Currency Type, Use CNY
				$transdate = date('Ymd'); # Order Date
				$busicode = "0001"; # Transaction type, Consume

				$pagereturl = "http://hict.cc/order/payback"; # Feedback Url
				$bgreturl = "http://hict.cc/order/payback";
				$productdesc='Iphone6 plus';
				?>
				<html>
				<body onload="document.getElementById('form').submit();">
				<form id="form" action="https://webpaywg.bestpay.com.cn/payWeb.do" method="post">
					<input type=hidden name="MERCHANTID" value="<?php echo $merid; ?>"/>
					<input type=hidden name="ORDERSEQ" value="<?php echo $ordid; ?>"/>
					<input type=hidden name="ORDERREQTRANSEQ" value="<?php echo $orderreqtranseq; ?>"/>
					<input type=hidden name="ORDERDATE" value="<?php echo $orderdate; ?>"/>
					<input type=hidden name="ORDERAMOUNT" value="<?php echo $orderamount; ?>"/>
					<input type=hidden name="PRODUCTAMOUNT" value="<?php echo $productamount; ?>"/>
					<input type=hidden name="ATTACHAMOUNT" value="<?php echo $attachamount; ?>"/>

					<input type=hidden name="CURTYPE" value="<?php echo $curtype; ?>"/>
					<input type=hidden name="ENCODETYPE" value="<?php echo $encodetype; ?>"/>
					<input type=hidden name="MERCHANTURL" value="<?php echo $pagereturl; ?>"/>
					<input type=hidden name="BACKMERCHANTURL" value="<?php echo $bgreturl; ?>"/>
					<input type=hidden name="BUSICODE" value="<?php echo $busicode; ?>"/>
					<input type=hidden name="PRODUCTDESC" value="<?php echo $productdesc; ?>"/>
					<input type=hidden name="MAC" value="<?php echo $mac; ?>"/>
				</form>
				</body>
				</html>
			<?php
			}
			else {
				die('Failed');
			}
		}
	}

	public function getOrdersByUid($user_id,$status){
		return  $this->select('orders.id,orders.name,orders.order_number,orders.status,orders.mid as merchant_id')->from('orders')
				->join('users', array('users.id' => 'orders.uid'))
				->where(array(
						'orders.uid' => $user_id,
						'orders.type'=>null,
						'orders.status' => $status
				))->orderBy('orders.id')->result();
	}

	public function getOrdersByStatus($user_id,$status='all',$offset=0,$count=10,$type){
		$now = new \DateTime();
		$time=$now->format('Y-m-d H:i:s');
		$where = array('orders.uid' => $user_id);
		if($status=='nopay') {
			$where[] = new \Clips\Libraries\OrOperator(array('orders.status'=>'NOPAY'));
		}elseif($status=='Assigned'){
			$where['orders.status'] = 'Assigned';
		}elseif($status=='received'){
			$where['orders.status'] = 'RECEIVED';
		}elseif($status=='pay'){
			$where['orders.status'] = 'PAY';
		}elseif($status=='use'){
			$where['orders.status'] = 'USE';
		}elseif($status=='expired'){
			//$where['orders.status'] = 'EXPIRED';
			$where[] = new \Clips\Libraries\CommonOperator('products.expire_date',$time, '<=');
		}else{
			new \Clips\Libraries\CommonOperator('orders.status', 'DELETE', '!=');
		}
		if($type=='product') {
			$where['orders.type'] = null;
			$where['products.category_id'] = 1;
		}elseif($type=='bestpay_coupon'){
			$where['orders.type'] = null;
			$where['products.category_id'] = 2;
		}elseif($type=='my_coupon') {
			new \Clips\Libraries\NotOperator(array('orders.type' => null));
		}
		$where[] =new \Clips\Libraries\CommonOperator('orders.status', 'DELETE', '!=');
		return  $this->select('merchants.name as merchant_name,orders.type,orders.id,order_items.product_id,orders.uid,orders.order_number,orders.status,orders.mid as merchant_id')->from('orders')
				->join('merchants', array('merchants.id' => 'orders.mid'))
				->join('users', array('users.id' => 'orders.uid'))
				->join('products', array('order_items.product_id' => 'products.id'))
				->join('order_items', array('orders.id' => 'order_items.order_id'))
				->where($where)
				->orderBy('orders.id desc')
				->groupBy('orders.id')
				->limit($offset,$count)
				->result();
	}

	public function getCouponsByStatus($user_id,$status='all',$offset=0,$count=10){
		$now = new \DateTime();
		$time=$now->format('Y-m-d H:i:s');
		$where = array('orders.uid' => $user_id);
		if($status=='nopay') {
			$where[] = new \Clips\Libraries\OrOperator(array('orders.c_status'=>'NOPAY'));
		}elseif($status=='pay'){
			$where['orders.c_status'] = 'PAY';
		}elseif($status=='use'){
			$where['orders.c_status'] = 'USE';
		}elseif($status=='expired'){
			//$where['orders.status'] = 'EXPIRED';
			$where[] = new \Clips\Libraries\CommonOperator('products.expire_date',$time, '<=');
		}else{
			new \Clips\Libraries\CommonOperator('orders.c_status', 'DELETE', '!=');
		}

		$where['orders.type'] = null;
		$where['products.category_id'] = 2;

		$where[] =new \Clips\Libraries\CommonOperator('orders.c_status', 'DELETE', '!=');
		return  $this->select('merchants.name as merchant_name,orders.type,orders.id,order_items.product_id,orders.uid,orders.order_number,
							orders.status,orders.c_status,orders.mid as merchant_id')
				->from('orders')
				->join('merchants', array('merchants.id' => 'orders.mid'))
				->join('users', array('users.id' => 'orders.uid'))
				->join('products', array('order_items.product_id' => 'products.id'))
				->join('order_items', array('orders.id' => 'order_items.order_id'))
				->where($where)
				->orderBy('orders.id desc')
				->groupBy('orders.id')
				->limit($offset,$count)
				->result();
	}


	public function getOrdersByGetStatus($user_id,$status){
		return  $this->select('orders.id,orders.name,orders.order_number,orders.status,orders.mid as merchant_id')->from('orders')
				->join('users', array('users.id' => 'orders.uid'))
				->where(array(
						'orders.uid' => $user_id,
						'orders.status' => $status
				))->orderBy('orders.id')->result();
	}

	public function getOrdersByMid($user_id){
		return  $this->select('orders.id,orders.name,orders.order_number,orders.status,orders.mid as merchant_id')->from('orders')
				->join('users', array('users.id' => 'orders.uid'))
				->join('merchants', array('merchants.id' => 'orders.mid'))
				->where(array(
						'orders.uid' => $user_id
				))->orderBy('orders.id')->result();
	}
	public function cancel_order($post){
		if($post)
			return $this->order->update((object)array(
					'id' =>$post['id'],
					'status' =>$post['status'],
					'cancel_reason' => $post['reason'],
					'instruction' => $post['instruction'],
					'timestamp' =>''
			));
	}

	public function getMerchantName($uid,$product){
		if($product='product'){
			$where['products.category_id'] = 1;
		}
		if($product='coupon'){
			$where['products.category_id'] = 2;
		}

		$where['orders.uid']=$uid;
		return  $this->select('merchants.name as merchant_name,products.category_id')->from('orders')
				->join("merchants",array('merchants.id'=>'orders.mid'))
				->join('products', array('products.id' => 'order_items.product_id'))
				->join('order_items', array('order_items.order_id' => 'orders.id'))

				->where($where)
				->orderBy('orders.id')->result();
	}


	public function getMerchantOrdersByStatus($status='all',$offset=0,$count=10,$type){
		$merchants=$this->merchant->load($this->merchant->getCurrentMerchantID());
		if($status=='NOPAY') {
			$where[] = new \Clips\Libraries\OrOperator(array('orders.status'=>'NOPAY'));
		}elseif($status=='PAY'){
			$where['orders.status'] = 'PAY';
		}elseif($status=='Distributed'){
			$where['orders.status'] = 'Distributed';
		}elseif($status=='Assigned'){
			$where['orders.status'] = 'Assigned';
		}elseif($status=='Received'){
			$where['orders.status'] = 'received';
		}elseif($status=='UserCancelled'){
			$where['orders.status'] = 'UserCancelled';
		}elseif($status=='MerCancelled'){
			$where['orders.status'] = 'MerCancelled';
		}else{
			new \Clips\Libraries\CommonOperator('orders.status', 'DELETE', '!=');
		}
		if($type=='product') {
			$where['orders.type'] = null;
			$where['products.category_id'] = 1;
		}elseif($type=='bestpay_coupon'){
			$where['orders.type'] = null;
			$where['products.category_id'] = 2;
		}elseif($type=='my_coupon') {
			new \Clips\Libraries\NotOperator(array('orders.type' => null));
		}
		$where[] =new \Clips\Libraries\CommonOperator('orders.status', 'DELETE', '!=');
		if($merchants->parent==null){
		}else{
			$where['orders.merchant_id']=$this->merchant->getCurrentMerchantID();
		}
		return  $this->select('products.category_id,orders.type,orders.id,order_items.product_id,orders.uid,orders.name,orders.order_number,orders.status,orders.merchant_id')->from('orders')
				->join('users', array('users.id' => 'orders.uid'))
				->join('products', array('order_items.product_id' => 'products.id'))
				->join('order_items', array('orders.id' => 'order_items.order_id'))
				->where($where)
				->orderBy('orders.id desc')
				->groupBy('orders.id')
				->limit($offset,$count)
				->result();
	}

	public function getDistributed(){
		return $this->get(array('orders.status' => 'DISTRIBUTED'));
	}
	public function getReceived(){
		return $this->get(array('orders.status' => 'RECEIVED'));
	}
	public function  getOrdersCount($user_id,$status='all',$type){
		$where = array('orders.uid' => $user_id);
		if($status=='nopay') {
			$where[] = new \Clips\Libraries\OrOperator(array('orders.status'=>'NOPAY'));
		}elseif($status=='distributed'){
			$where['orders.status'] = 'DISTRIBUTED';
		}elseif($status=='received'){
			$where['orders.status'] = 'received';
		}elseif($status=='pay'){
			$where['orders.status'] = 'PAY';
		}elseif($status=='use'){
			$where['orders.status'] = 'USE';
		}elseif($status=='expired'){
			$where['orders.status'] = 'EXPIRED';
		}elseif($status=='Assigned') {
			$where['orders.status'] = 'Assigned';
		}else {
			$where[]=new \Clips\Libraries\CommonOperator('orders.status', 'DELETE', '!=');
		}

		if($type=='product') {
			$where['orders.type'] = null;
			$where['products.category_id'] = 1;
		}elseif($type=='bestpay_coupon'){
			$where['orders.type'] = null;
			$where['products.category_id'] = 2;
		}elseif($type=='my_coupon') {
			new \Clips\Libraries\NotOperator(array('orders.type' => null));
		}
		$res = $this->select('orders.type,orders.id,orders.name,orders.order_number,orders.status,orders.mid as merchant_id')->from('orders')
				->join('users', array('users.id' => 'orders.uid'))
				->join('products', array('order_items.product_id' => 'products.id'))
				->join('order_items', array('orders.id' => 'order_items.order_id'))
				->where($where)
				->orderBy('orders.id desc')
				->groupBy('orders.id')
				->result();
		return count($res);
	}

	public function getCouponsCount($user_id,$status='all'){
		$where = array('orders.uid' => $user_id);
		if($status=='nopay') {
			$where[] = new \Clips\Libraries\OrOperator(array('orders.c_status'=>'NOPAY'));
		}elseif($status=='pay'){
			$where['orders.c_status'] = 'PAY';
		}elseif($status=='use'){
			$where['orders.c_status'] = 'USE';
		}elseif($status=='expired'){
			$where['orders.c_status'] = 'EXPIRED';
		}else {
			$where[]=new \Clips\Libraries\CommonOperator('orders.c_status', 'DELETE', '!=');
		}
		$where['orders.type'] = null;
		$where['products.category_id'] = 2;

		$res = $this->select('orders.type,orders.id,orders.name,orders.order_number,orders.status,orders.c_status,orders.mid as merchant_id')->from('orders')
				->join('users', array('users.id' => 'orders.uid'))
				->join('products', array('order_items.product_id' => 'products.id'))
				->join('order_items', array('orders.id' => 'order_items.order_id'))
				->where($where)
				->orderBy('orders.id desc')
				->groupBy('orders.id')
				->result();
		return count($res);
	}

	public function getOrderByItemID($item_id){
		return $this->select('products.expire_date,orders.*')->from('orders')
				->join('products',array('products.id'=>'order_items.product_id'))
				->join('order_items',array('orders.id'=>'order_items.order_id'))
				->where(array('order_items.id'=>$item_id))
				->result();
	}

	public function updateStatus($id,$status){
		$this->update((object)array(
				'id' => $id,
				'c_status'=>$status
		));
	}

	public function confirm_order($post){
		if($post)
			return $this->order->update((object)array(
					'id' =>$post['id'],
					'status' =>'received',
			));
	}

	public function getOrdersCountByMerchant($status='all',$type){
		$merchants=$this->merchant->load($this->merchant->getCurrentMerchantID());
		if($status=='NOPAY') {
			$where[] = new \Clips\Libraries\OrOperator(array('orders.status'=>'NOPAY'));
		}elseif($status=='PAY'){
			$where['orders.status'] = 'PAY';
		}elseif($status=='Distributed'){
			$where['orders.status'] = 'Distributed';
		}elseif($status=='Assigned'){
			$where['orders.status'] = 'Assigned';
		}elseif($status=='Received'){
			$where['orders.status'] = 'received';
		}elseif($status=='UserCancelled'){
			$where['orders.status'] = 'UserCancelled';
		}elseif($status=='MerCancelled'){
			$where['orders.status'] = 'MerCancelled';
		}else{
			$where[]=new \Clips\Libraries\CommonOperator('orders.status', 'DELETE', '!=');
		}

		if($type=='product') {
			$where['orders.type'] = null;
			$where['products.category_id'] = 1;
		}elseif($type=='bestpay_coupon'){
			$where['orders.type'] = null;
			$where['products.category_id'] = 2;
		}elseif($type=='my_coupon') {
			$where[]=new \Clips\Libraries\NotOperator(array('orders.type' => null));
		}
		if($merchants->parent==null){
		}else{
			$where['orders.merchant_id']=$this->merchant->getCurrentMerchantID();
		}
		$res = $this->select('orders.type,orders.id,orders.name,orders.order_number,orders.status,orders.mid as merchant_id')->from('orders')
				->join('users', array('users.id' => 'orders.uid'))
				->join('products', array('order_items.product_id' => 'products.id'))
				->join('order_items', array('orders.id' => 'order_items.order_id'))
				->where($where)
				->orderBy('orders.id desc')
				->groupBy('orders.id')
				->result();
		return count($res);
	}
}
