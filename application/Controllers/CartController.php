<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\BaseController;

	/**
	* @Clips\MessageBundle(name="cart")
	* @Clips\Widget({"html", "lang", "grid", "image", "bootstrap","navigation","form", "yizhifu"})
	* @Clips\Context(key = 'test_data', value = 'navigation')
	* @Clips\Object('testData')
	*/
class CartController extends BaseController {

	/**
	* @Clips\Model({"product","user","cart"})
	* @Clips\Widgets\DataTable("cart_index")
	* @Clips\Scss("cart/index_moblie")
	*/
    public function index() {
	    //* @Clips\Scss("cart/index")
		// Add the init js, add this to a js file is fine too.
		\Clips\context('jquery_init',
		<<<TEXT

	//====================================
	// Initializing Sliders
	//====================================

	//====================================
	// Other Events
	//====================================
TEXT
		, true);
		$this->title('My Cart Page',true);
		$args = array(
			'products'=> array()
		);
//	    return $this->render('cart/test');
		//return $this->render('cart/index', $args);
	    if($this->request->isMobile()){
		    return $this->render('cart/index_moblie');
	    }
	    else {
		    return $this->render('cart/index', $args);
	    }
	}

	public function add(){
		return $this->redirect(\Clips\site_url('cart/index'));
	}

	/**
	 * @Clips\Model({"user","customer","cart"})
	 */
	public function addCart(){
		$uid = $this->user->getCurrentUserId();
		if($uid){
			$customer = $this->customer->getCustomer($uid);
			$data = $this->cart->add($customer->id,$this->post('product_id'),$this->post('number'));
			if($data)
				echo json_encode(array('success'=>true, 'msg'=>$this->bundle->message('Card Add successfully')));
			else{
				echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('Card Add failed')));
			}
		}else{
			return $this->redirect('http://user.pinet.co/api/login?appid=4000&template=user&callback='.\Clips\site_url('user/register', true));
		}

	}

	/**
	 * @Clips\Model({"user","customer","cart"})
	 * @Clips\Form("cart/buy")
	 */
	public function buy(){
		$product = $this->product->load('501');
		$merchant=$this->merchant->getMerchant($product->merchant_id);
		$product->description = $merchant->description;
		$this->formData('cart/buy', $product);
		return $this->redirect(\Clips\site_url('cart/index'));
	}
	/**
	 * @Clips\Model({"user","customer","cart","product","merchant"})
	 * @Clips\Form("cart/buy")
	 */
	public function buy_form(){
		$product = $this->product->load('501');
		$merchant=$this->merchant->getMerchant($product->merchant_id);
		$product->description = $merchant->description;
		$this->formData('cart/buy', $product);
		return $this->redirect(\Clips\site_url('cart/index'));

	}
}
