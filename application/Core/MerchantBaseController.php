<?php namespace Pinet\BestPay\Core; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Controller;
use Clips\Interfaces\Initializable;

/**
 * The Merchant Base controller for all controllers
 *
 * @author Jake
 * @since 3/19/15 9:39 AM
 */
class MerchantBaseController extends Controller implements Initializable {
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
		$this->merchant = $this->tool->model('merchant');
		$merchant = $this->merchant->load($this->merchant->getCurrentMerchantID());
		$this->request->session('bestpay_username',$merchant->name);
		$url = \Clips\site_url('user/logout',true);
		$uc_site = 'http://user.pinet.co/api/login?appid=4000&template=user&callback='.\Clips\site_url('user/register', true);
		if($merchant){
			$head = $this->actions(
					array('home/index', 'Welcome to yibai'),
					array('user/orders', $merchant->name),
					array($url, 'Sign Out', 'external')
			);
		}else{
			$head = $this->actions(
					array('home/index', 'Welcome to yibai')
			);
		}

		$actions = $this->actions(
			array('admin/coupon/check")', 'Check Coupon'),
			array('admin/coupon/status")', 'Coupon Voucher Status'),
			array('admin/coupon/record', 'Checked Coupon Record')
		);
		$navigation = $this->actions(
			array('admin/coupon/check', 'Check Coupon'),
			array('admin/merchant/orders', 'Customers Management'),
			array('alert("Not Implemented yet!")', 'My Shop', 'client')
		);
		$args['navi'] = $navigation;
		$args['actions'] = $actions;
		$args['head'] = $head;

		return parent::render($template, $args, $engine, $headers);
	}

	public function pages($total,$pagesize=10,$page_no,$url){
		$page_no = $page_no<1 ? 1 : $page_no;

		$page = new \Pinet\BestPay\Core\Pages();
		$pagestr = $page->multi($total,$pagesize,$page_no,\Clips\site_url($url),'');
		return $pagestr;
	}
}
