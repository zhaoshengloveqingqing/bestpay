<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\BaseController;

	/**
	* @Clips\Widget({"html", "lang", "grid", "image", "bootstrap","navigation","form", "yizhifu"})
	* @Clips\MessageBundle(name="merchant")
	* @Clips\Context(key = 'test_data', value = 'navigation')
	* @Clips\Object('testData')
	*/
class MerchantController extends BaseController {

	/**
	* @Clips\Widgets\DataTable("merchant_index")
	*/
	public function index() {
		return $this->render('merchant/index');
	}

	/**
	 * @Clips\Model({"user","cart"})
	 */
	public function login(){
		if(isset($_SESSION['merchant_id'])) {
			return $this->redirect(\Clips\site_url('admin/coupon/check', true));
		}
		return $this->redirect('http://user.pinet.co/api/logout?appid=4000&template=merchant&ndr=false&callback='.\Clips\site_url('merchant/login_success', true));
	}

	/**
	* @Clips\Library("encryptor")
	* @Clips\Model({"user", "merchant","cart"})
	*/
	public function login_success(){
		if($this->get('token')){
			if(!isset($_SESSION['merchant_id'])) {
				$_SESSION = array();
			}
			$token = json_decode($this->encryptor->publicDecrypt($this->get('token')));
//			var_dump($token);die;
			if(isset($token->uid)){
				$this->user->setCurrentUserID($token->uid);
				$merchant = $this->merchant->getMerchantID($token->uid);
				if(isset($merchant->id))
				$this->merchant->setMerchantID($merchant->id);
				return $this->redirect(\Clips\site_url('admin/coupon/check', true));
			}
		}
		return $this->redirect('http://user.pinet.co/api/logout?appid=4000&template=merchant&callback='.\Clips\site_url('merchant/login_success', true));
	}
	/**
	* @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	* @Clips\Form("merchant/show")
	* @Clips\Model({"user","merchant"})
	*/
	public function show($id){
		$this->title('Merchant Information', true);
		$merchant = $this->merchant->load($id);
		$this->formData("merchant/show", $merchant);
		$form_action = \Clips\site_url('merchant/index');
		return $this->render('merchant/show', array('form_action' => $form_action));
	}

	/**
	 * @Clips\Model("merchant")
	 * @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	 *  @Clips\Widgets\ListView("merchant_detail")
	 * @Clips\Scss("merchant/details")
	 */
	public function details(){
		$merchant = $this->merchant->getMerchantsID();
		$this->title('Merchant Details', true);
		return $this->render('merchant/details',array('merchant'=>$merchant[0]));
	}
}
