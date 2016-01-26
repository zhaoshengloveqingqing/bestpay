<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\BaseController; 

	/**
	* @author Jack
	* @date Sat Mar 14 19:05:22 2015
	*
	* @Clips\Widget({"html", "lang", "grid", "image", "bootstrap","navigation","form", "yizhifu"})
	* @Clips\MessageBundle(name="product")
	* @Clips\Context(key = 'test_data', value = 'navigation')
	* @Clips\Object('testData')
	*/
class ProductController extends BaseController {
	/**
	* @Clips\Widgets\ListView("home_index")
	* @Clips\Scss("product/index")
	*/
	public function index() {
		$this->title('Popular Discount',true);
		$alert = 'alert("Not Implemented!");';
		$args = array(
			'data' => array(),
			'all' => $this->action($alert, 'All', 'client'),
			'food' => $this->action($alert, 'Food', 'client'),
			'beauty' => $this->action($alert, 'Beauty', 'client'),
			'recreation' => $this->action($alert, 'Recreation Entertainment', 'client'),
		);
		return $this->render('product/product_list', $args);
	}

	/**
	 * TODO Just list coupons
	 */
	public function coupons() {
		echo "COUPONS";
	}

	/**
	* @Clips\Model({"product","merchant","user","productPhoto","cart","productTag","tag"})
	* @Clips\Form({'product/product','ajaxlogin'})
	* @Clips\Scss("product/product")
	* @Clips\Widgets\ListView("merchant_information")
	* @Clips\Widget({"qrcode","jqzom","slider"})
	* @Clips\Js("application/static/js/product/buy.js")
	* @Clips\Js("application/static/js/product/show.js")
	* @Clips\Js("application/static/js/cart/add.js")
	* @Clips\Js("application/static/js/product/dialog.js")
	*/
	public function show($id) {
		// Add the init js, add this to a js file is fine too.
		\Clips\context('jquery_init',
				<<<TEXT

	//====================================
	// Initializing Sliders
	//====================================
//	$("#banner-slider").owlCarousel({
//		items : 1,
//		itemsCustom : false,
//		itemsDesktop : [1199,1],
//		itemsDesktopSmall : [980,1],
//		itemsTablet: [768,1],
//		itemsTabletSmall: false,
//		itemsMobile : [479,1],
//		singleItem : false,
//		itemsScaleUp : false,
//		autoPlay: true
//	});
	//====================================
	// Other Events
	//====================================
TEXT
				, true);




		$url = \Clips\site_url('product/show/'.$id,true);
		$product = $this->product->load($id);
		if($this->product->isCoupon($product)) {
			$this->title('Coupon View',true);
		}
		else
			$this->title('Product View',true);
		if(!$product) {
			// Report error if no product is found!
			$this->error('Can\'t find any product based on ID '.$id.'!', 'Not Found');
			return;
		}
        if(!$product->merchant_id){
            $this->error('Cant\'t find merchant based on Merchant_ID'.$product->merchant_id.'!','Not Found');
            return;
        }
        $merchant=$this->merchant->getMerchant($product->merchant_id);
        $product->path = $this->product->getProductByID($id)[0]->path;
        $product->description = $merchant->description;
		$product->url = $url;
		$product->longitude = $merchant->longitude;
		$product->latitude = $merchant->latitude;
		$product->location = $merchant->location;
		$this->formData('product/product', $product);
		$form_action = \Clips\site_url('order/confirm');
		$uid = $this->user->getCurrentUserId();
		$productPhotos = $this->productphoto->getProductPhotos($id);
		foreach($productPhotos as $k=>$v){
			$paths[] = $v;
		}
		foreach($paths as $v){
			$path[] =
					(object) array('url'=>'application/static/upload/img/'. $v->path);
		}
		$mers = $this->merchant->getTestByUid('2');
		foreach($mers as $k=>$v){
			$v;
		};
		$post_action = \Clips\site_url('product/show_ajax');
		$url ='http://user.pinet.co/api/get_code';
		$cartamount = $this->cart->getCartsByProductID($product->id);
		$totalamount=0;
		for($i=0;$i<count($cartamount);$i++){
			$totalamount+=$cartamount[$i]->amount;
		}
		$product_tags = $this->producttag->getProductTagsByID($id);
//		var_dump($product_tags);die;
		foreach($product_tags as $k=>$v){
			$products_tagName[$k] = $this->tag->getProductTagsByTagID($v->tag_id);
			$products_tagName[$k] =$products_tagName[$k]->name;

		}
		$parent_tagName = $products_tagName[0];
		unset($products_tagName[0]);
		$chiled_tagNames=$products_tagName;

//		$p[] = array('products.id' => $id);
//		//自定义查询
//		$this->request->session('merchant_information', $p);

		return $this->render('product/product',array('parent_tagName'=>$parent_tagName,'chiled_tagNames'=>$chiled_tagNames,'cartamount'=>$totalamount,'mers'=>$mers,'user_id'=>$uid,'product'=>$product, 'form_action'=>$form_action, 'items'=>$path,"url"=>$url,'post_action'=>$post_action));
	}

	public function show_ajax() {
		//curl
		return $this->redirect('http://user.pinet.co/api/login?appid=-1&validation_code=111111&mobile=13656227964&template=user&callback='.\Clips\site_url('user/register', true));
	}
}
