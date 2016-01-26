<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Object;
use Pinet\BestPay\Core\BaseController;

/**
 * @Clips\Widget({"html", "lang", "grid", "image", "bootstrap","navigation","form", "yizhifu"})
 * @Clips\MessageBundle(name="order")
 * @Clips\Context(key = 'test_data', value = 'navigation')
 * @Clips\Object('testData')
 */
class OrderController extends BaseController {
	/**
	 * @Clips\Model({"paymentMethod","user","cart","order","product","customer","merchant","place"})
	 * @Clips\Form("order/confirm")
	 * @Clips\Widget({"selectboxit", "productlist"})
	 * @Clips\Widgets\ListView("home_index")
	 * @Clips\Scss("order/confirm")
	 * @Clips\Js("application/static/js/order/buy.js")
	 * @Clips\Js("application/static/js/order/confirm.js")
	 */
	public function confirm() {
		$this->formData('select', array('province' => 'Jiangsu', 'city' => 'Nanjing', 'district' => 'Gulou'));
		$arguments = array(
				'province'=>array(
						array(
								'label'=>'Jiangsu',
								'value'=>'Jiangsu'
						),
						array(
								'label'=>'Anhui',
								'value'=>'Anhui'
						)
				)
		);
		//return $this->render('order/confirm', $arguments);

		$children_merchants = array('配送','自提');

		$args = array_merge(array('=请选择='),$children_merchants);

		$this->title('Pay',true);
		$user_id = $this->user->getCurrentUserId();
		$rand = $this->order->get_shop_sn();
		$payments = $this->paymentmethod->get('status','ACTIVE');
//		$product = $this->order->getProductWhenBuy($this->post());
		if($this->request->session('user_id')){
			if($this->request->session('product_data')){
				$this->request->session('is_cart','');
				$sess=$this->request->session('product_data');
				$this->request->session('spm','');
//				var_dump($sess);die;
				$products = $this->product->getProductsByCart($sess['id']);
				$product_amount=$this->product->load($sess['id'])->amount;
				$product_count = count($sess['id']);
				$sess['path']=\Clips\site_url('application/static/upload/img/'.$sess['path'],true);
				$datajson = json_encode(array(array((Object)$sess)));
				$data = $this->merchant->getMerchantsIDByProductID($sess['id'])[0]->name;
			}

			if($this->post()!=null && $this->post('product')!=null) {
				unset($_SESSION['display']);
				$this->request->session('is_cart','');
				$this->request->session('spm','');
				$product = $this->post();
				$product_amount=$this->product->load($product['id'])->amount;
				$products = $this->product->getProductPhotosByPid($product['id']);
				$product['itemId'] = $rand;
				$product['price'] = $product['discount_price'][0]*$product['number'][0];
				$data = $this->merchant->getMerchantsIDByProductID($product['id'])[0]->name;
				$product['product_id'] = $product['id'];
				$product['type'] = 'buy';
				$product['category_id'] = $products->category_id;
				$product['ori_price'] = $product['discount_price'][0];
				$product['path']=$products->path;
				$sess=$this->request->session('product_data',$product);
				$product_count = count($product['id']);
				$sess['path']=\Clips\site_url('application/static/upload/img/'.$sess['path'],true);
				$datajson = json_encode(array(array((Object)$sess)));
				$this->request->session('product_get','product_get');
			}
			if($this->post()==null&& $this->get('spm')!=null  || $this->request->session('product_get')==null )
			{
				unset($_SESSION['display']);
				$this->request->session('is_cart','cart_buy');
				$this->request->session('product_get','');
				$productsByCart = $this->cart->getProductsByCart($user_id);
				for($i=0;$i<count($productsByCart);$i++){
					$productsByCart[$i]->path = \Clips\site_url('application/static/upload/img/'.$productsByCart[$i]->path,true);

				}
				for($i=0;$i<count($productsByCart);$i++){
					$productsByCart[$i]->itemId = $productsByCart[$i]->product_id.$rand;
				}
				$merchants=array();
				$merchantsByID=array();
				$arr=array();
				$tmp=array();
				foreach($productsByCart as $item){
					in_array($item->merchant_name,$merchants)? function () use(&$item){unset($item);}:$merchants[]->merchant_name = $item->merchant_name;
//					$merchants=$merchants['merchant_name'];
				}

//				var_dump($merchants);die;
				array_walk(
						$merchants,
						function($item,$key)use(&$tmp,&$merchants){
							if(in_array($item->merchant_name,$tmp,true)){
								unset($merchants[$key]);
							}else{
								$tmp[]=$item->merchant_name;
							}
						}
				);

				foreach($merchants as $k=>$v){
					$merchants[$k]=$v->merchant_name;
				}
				$data=array_unique($merchants);
				sort($data);
//				print_r($data);die;
				foreach($productsByCart as $item){
					in_array($item->merchant_id,$merchantsByID)||$merchantsByID[]=$item->merchant_id;
				}
				foreach($merchantsByID as $merchant){
					foreach ($productsByCart as $k=>$goods) {
						if($goods->merchant_id==$merchant){
							$arr[$merchant][]=$goods;
//						unset($goods);
						}
					}
				}

				$ks =array();
				foreach($arr as $k=>$v){
					$ks[]=$v;
				}
//				var_dump($ks);die;
				$datajson = json_encode($ks);
				$product_amount=$this->product->load($productsByCart[0]->product_id)->amount;
				$product_count = count($productsByCart);
			};

			$user_infos = $this->user->get_userinfo($this->request->session('token'));
			$this->formData("order/confirm",$user_infos);
			$form_action = \Clips\site_url('order/pay');
			$jump_url = \Clips\site_url('order/add_address');
			$js = <<<TEXT
	var datajsonobj = $datajson;

	function removeProduct(type,id) {
			console.log(type, id);
			$.post(Clips.siteUrl('order/delOrder'),{type:type,carts_id:id},function(result){
				alert('删除成功');
			});

	}

	$('[control=each]').each(function(i){
		if(datajsonobj[i]) {
			var products = new ProductList('#order-list'+i);
			products.render(datajsonobj[i], function(list){
				setSpinnerPlugin(list, function(){
					removeProduct(list);
				});
				setRemovePlugin(list, function(item){
					removeProduct(item.data('itemData').type,item.data('itemData').id);
				});
				setTotalPricePlugin(list);
			});
		}
	});

TEXT;
				\Clips\context('jquery_init', $js, true);
				$user_id = $this->user->getCurrentUserId();
				$address = $this->user->deliveryAddressByUid($user_id);
				for($i=0;$i<count($address);$i++){
					$address[$i]->count=count($address);
				}
				$default_address = $this->user->getDefaultAddress($user_id);
//				$product->delivery_address = $default_address->delivery_address;
				$user_infos->product_count = $product_count;
				$this->request->session('product',null);
			;
				$display = $this->request->session('display');
				if(!isset($display)) {
					$display = true;
				}
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
					$address[$i]->province_children =$a[$i];
					$address[$i]->city_children =$b[$i];
					$address[$i]->area_children =$c[$i];
				}
				if($address==null){
					$default='no';
				}
				$place = $this->place->getElementName($default_address->province)->name.$this->place->getElementName($default_address->city)->name.$this->place->getElementName($default_address->area)->name;
				return $this->render('order/confirm', array('product_amount'=>$product_amount,'sess'=>$sess,'CartCount'=>count($productsByCart),'jump_url'=>$jump_url,
						'ks'=>$ks,'default'=>$default,'merchants'=>$data,'header' => 'Home',
						'province' => $this->place->listProvince(),
						'payments'=>$payments,'user_infos'=>$user_infos, 'form_action'=>$form_action, 'address'=>$address,
						'children_merchants'=>$args,'default_address'=>$default_address,'default_address_id'=>$default_address->id,'display'=>$display,'place'=>$place));
			}else{
				$url = \Clips\site_url('order/confirm/'.$this->post('product_id')[0],true);
				$this->request->session('buy_callback',$url);
				$this->request->session('post_number',(integer) $this->post('number', 0));
				return $this->redirect('http://user.pinet.co/api/logout?appid=4000&template=user&callback='.\Clips\site_url('user/register',true));
			}
//		};


	}

	/**
	 * @Clips\Model({"user","customer"})
	 */
	public function getCid(){
		if($this->post('id')){
			return $data = $this->customer->load($this->post('id'));
		}
		return false;
	}


	/**
	 * @Clips\Model({"cart"})
	 */
	public function delOrder(){
		$carts_id = $this->request->post('carts_id');
		$type = $this->request->post('type');
		if($type == 'buy') {
			$this->request->session('product_data',null);
			$this->request->session('display',false);
		}else{
			$this->cart->delete($carts_id);
		}
	}

	/**
	 * @Clips\Model({"order","paymentMethod","cart"})
	 * @Clips\Scss("order/success")
	 * @Clips\Widgets\ListView("user_orders")
	 * @Clips\Scss("user/orders")
	 */
	public function pay_form(){
		$this->title('Pay Success',true);
		$payments = $this->paymentmethod->get('status','ACTIVE');

		$orders = $this->post('name');
		if(count($orders)==0) {
			$url = \Clips\site_url('home/index');
			echo "<script>alert('订单不能为空！');window.location.href='$url';</script>";
			die;
		}
		$data=$this->order->gotoPay($this->post(),$payments[0]->id);
		$this->request->session('orders_ID',$data);
		$this->request->session('is_cart','no_cart');
		return $this->redirect(\Clips\site_url('user/orders'));
	}

	/**
	 * @Clips\Model({"order","product","orderItem"})
	 * @Clips\Scss("order/success")
	 */
	public function success(){
		$orders=$this->request->session('orders_ID');
		if(count($orders)>1){
			$orders;
		}else{
			$orders=array($orders);
		}
		foreach($orders as $v){
			$order[] = $this->order->load($v);
			$order_details[] =  $this->orderitem->getOrderItemsByOrderID($v);

		}

		foreach ($order_details as $k=>$v) {
			foreach($v as $k1=>$v1){
				if($order_details[$k]>1){
					$order_details[$k][$k1]->total_price=$v1->price*$v1->amount;
				}
			}
		}
		return $this->render('order/success',array('order_details'=>$order_details,'product_show'=>$v));
	}

	/**
	 * @Clips\Model({"order"})
	 * @Clips\Widget({"selectboxit","grid", "image", "bootstrap", "yizhifu"})
	 * @Clips\Widgets\ListView("user_orders")
	 * @Clips\Scss("user/orders")
	 */
	public function pay($order_id){
		$this->order->updateOrder($order_id);
		return $this->redirect(\Clips\site_url('user/orders'));
	}

	/**
	 * @Clips\Model({"order"})
	 * @Clips\Widget({"selectboxit","grid", "image", "bootstrap", "yizhifu"})
	 * @Clips\Widgets\ListView("user_orders")
	 * @Clips\Scss("user/orders")
	 */
	public function payback(){
		$order_id = $this->order->updateOrderByBack();
		return $this->redirect(\Clips\site_url('order/success'));
	}

	/**
	 * @Clips\Model({"order","product","orderItem"})
	 * @Clips\Widgets\ListView("user_orders")
	 * @Clips\Widget({"selectboxit","grid", "image", "bootstrap", "yizhifu"})
	 * @Clips\Scss("user/order_details")
	 */
	public function deleteOrder($order_id,$type){
		$ks = $this->order->deleteOrder($order_id,$type);
		if($ks)
			echo json_encode(array('success'=>true, 'msg'=>$this->bundle->message('Order delete successfully!')));
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Order delete failed!')));
		}
	}

	/**
	 * @Clips\Model({"order"})
	 */
	public function receive($order_id){
		$now = new \DateTime();
		if(isset($order_id)){
			$this->order->update((object)array(
					'id'=>$order_id,
					'status' =>'Received',
					'timestamp'=>$now->format('Y-m-d H:i:s')
			));
			return $this->redirect('user/orders',true);
		}
		return false;
	}

	/**
	 * @Clips\Model({"order"})
	 */
	public function user_cancel($order_id){
		$ks = $this->order->cancelOrder($order_id);
		if($ks)
			echo json_encode(array('success'=>true, 'msg'=>$this->bundle->message('Order Cancel successfully!')));
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Order Cancel failed!')));
		}
	}

	/**
	 * @Clips\Model({"users","customer"})
	 */
	public function add_address() {
		$this->title('User List', true);
		$pt = $this->request->session('product_data');
		$this->request->session('product_data',$pt);
		if($this->post('id')){
			 $this->customer->edit_Address($this->request->post());
		}else{
			 $this->customer->add_Address($this->request->post());
		}

		$this->request->session('product',null);
		$this->request->session('spm','spm');
		return $this->redirect('order/confirm',true,array('product'=>$this->request->session('product_data')));
	}


	/**
	 * @Clips\Model({"users","customer"})
	 */
	public function address_delete($id){
		$res = $this->customer->address_delete($id);
		$this->logger->debug('address delete data is ', array($res));
		if($res) {
			echo json_encode(array('success' => true, 'msg' => $this->bundle->message('Address delete successfully!')));
		}
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Address delete failed!')));
		}
	}

	/**
	 * @Clips\Model({"users","customer"})
	 */
	public function address_default($id){
		$res = $this->customer->address_default($id);
		$this->logger->debug('address delete data is ', array($res));
		if($res) {
			echo json_encode(array('success' => true, 'msg' => $this->bundle->message('Delivery address set up successfully!')));
		}
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Delivery address set up failed!')));
		}
	}

}
