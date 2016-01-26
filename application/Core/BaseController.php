<?php namespace Pinet\BestPay\Core; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Controller;
use Clips\Interfaces\Initializable;

/**
 * The Base controller for all controllers
 *
 * @author Jack
 * @date Sat Mar 14 16:05:59 2015
 */
class BaseController extends Controller implements Initializable {

	public function init() {
		// Add the UA Compatible
		\Clips\context('html_meta', array('http-equiv' => 'X-UA-Compatible',
			'content' => 'IE=edge'), true);
		// Add the view port for phones
		\Clips\context('html_meta', array('name' => 'viewport',
			'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'), true);
		// Add the iPhone support
		\Clips\context('html_meta', array('name' => 'renderer',
			'content' => 'webkit'), true);
		// Add the cache control
		\Clips\context('html_meta', array('name' => 'Cache-Control',
			'content' => 'no-siteapp'), true);
	}

	protected function render($template, $args = array(), $engine = null, $headers = array()) {
//		var_dump($_SESSION);die;
        $uc_site = 'http://user.pinet.co/api/login?appid=4000&template=user&callback='.\Clips\site_url('user/register', true);
		$uid = $this->request->session('bestpay_username');
		$user_id = $this->request->session('user_id');
		$url = \Clips\site_url('user/logout',true);

		\Clips\context('jquery_init',
				<<<TEXT

	//====================================
	// Initializing Sliders
	//====================================
	//	$(".btn-default").on('click', function (e) {
	//		alert("Not Implemented yet!");
	//	});
	//====================================
	// Other Events
	//====================================
TEXT
				, true);

		if(isset($user_id)){
			$actions = $this->actions(
					array('home/index', 'Welcome to yibai'),
					array('user/orders', $uid),
					array($url, 'Sign Out', 'external')
			);
		}else{
			$actions = $this->actions(
					array('home/index', 'Welcome to yibai'),
					array($uc_site, 'Login', 'external')
			);
		}

		$action1 = $this->action('home/index', 'Home');
		$action2 = $this->action('mall/index', 'Mall');
		$action3 = $this->action('coupon/index', 'Card Coupon');
		$action4 = $this->action('car/index', 'Car');
		$action5 = $this->action('people/index', 'People');

		$navigation = array(
				$action1,
				$action2,
				$action3,
				$action4,
				$action5
		);
		if(isset($uid)){
			$carts = $this->actions(
					array('cart/index','Cart')
			);
		}else{
			$carts = $this->actions(
					array($uc_site, 'Login', 'external')
			);
		}

        $args['navi'] = $navigation;
        $args['actions'] = $actions;
		$args['cart'] = $carts;
		$my_order_url = \Clips\site_url('user/orders',true);
		$my_address = \Clips\site_url('user/my_address',true);
		$my_coupon = \Clips\site_url('user/my_coupon',true);
		$search_url = \Clips\site_url('search/search',true);
//		$key = $this->request->session('search_key');
//		$args['key'] = $key;
		$args['search_url'] = $search_url;
		if(isset($uid)){
			$args['my_bestpay'] = $this->actions(
					array($my_order_url, 'My order','external'),
					array($my_address, 'Delivery Address', 'external'),
					array($my_coupon, 'My Coupon', 'external')
			);
		}else{
			$args['my_bestpay'] = $this->actions(
					array($uc_site, 'My order','external'),
					array($uc_site, 'Delivery Address', 'external'),
					array($uc_site, 'My Coupon', 'external')
			);
		}
		$this->cart = $this->tool->model('cart');
		if(isset($user_id)){
			$args['cart'] = $this->cart->getCartCount($user_id);
			$args['cart']->jump_url = \Clips\site_url('order/confirm?spm=15gpk');
			$args['cart']->post_url =\Clips\site_url('order/confirm?spm=16gtp');
			$args['cart']->cart_count = count($this->cart->getProductsByCart($user_id))-1;
			$args['cart']->user_id = $user_id;
		}
		$args['productByCart'] = $this->cart->getProductsByCart($user_id);
		$count = count( $this->cart->getProductsByCart($user_id));
		for($i=0;$i<$count; $i++ ) {
			$args['productByCart'][$i]->cart_count=count($this->cart->getProductsByCart($user_id))-1;
		}

		return parent::render($template, $args, $engine, $headers);
	}

	public function pages($total,$pagesize=10,$page_no,$url){
		$page_no = $page_no<1 ? 1 : $page_no;

		$page = new \Pinet\BestPay\Core\Pages();
		$pagestr = $page->multi($total,$pagesize,$page_no,\Clips\site_url($url),'');
		return $pagestr;
	}
}
