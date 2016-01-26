<?php namespace Pinet\BestPay\Controllers\Admin; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Controller;

/**
 * @Clips\Widget({"html", "lang"})
 * @Clips\MessageBundle(name="admin")
 */
class HomeController extends Controller {

	/**
	  * @Clips\Form("admin/login")
	  * @Clips\Widget({"grid", "bootstrap", "image"})
	  * @Clips\Scss("admin/home")
	  */
	public function index() {
		$this->title('Merchant Login Page', true);
		return $this->render('admin/home', array('header' => 'Admin Home'));
	}

	/**
	  * @Clips\Model("user")
	  * @Clips\Form('admin/login')
	  */
	public function index_form() {
		$result = $this->user->testPassword($this->post('username'), $this->post('password'));
		if(is_numeric($result)){
			$this->request->session('user_id', $result);
			return $this->redirect(\Clips\static_url('admin/user/coupon'));
		}
		else{
			//TODO add alert info
			return $this->redirect(\Clips\static_url('admin/home'));
		}
	}
}
