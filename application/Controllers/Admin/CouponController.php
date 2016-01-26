<?php namespace Pinet\BestPay\Controllers\Admin; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\MerchantBaseController;

/**
 * @Clips\Widget({"html", "lang", "grid", "image", "bootstrap", "navigation", "yizhifu"})
 * @Clips\Scss("admin_layout/admin_layout")
 * @Clips\MessageBundle(name="coupon")
 */
class CouponController extends MerchantBaseController {
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
	 * @Clips\Form("admin/coupon/check")
	 * @Clips\Widget({"grid", "bootstrap", "image"})
	 * @Clips\Scss("admin/coupon/check")
	 * @Clips\Js("application/static/js/admin/coupon/check.js")
	 */
	public function check() {
		$this->title('Check Coupon Page', true);
		return $this->render('admin/coupon/check', array('merchants' => array()));
	}

	/**
	 * @Clips\Model({"product"})
	 */
	public function validate(){
		$result = $this->product->useCode($this->post('coupon_code'), $this->request->session("merchant_id"));
		if($result)
			echo json_encode(array('success'=>true, 'msg'=>$this->bundle->message('Validate code successfully!')));
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('This code is invalid!')));
		}
	}

    /**
     * @Clips\Form("admin/coupon/status")
     * @Clips\Widget({"grid", "bootstrap", "image"})
     * @Clips\Scss("admin/coupon/status")
	 * @Clips\Js("application/static/js/admin/coupon/status.js")
     */
    public function status(){
	    $this->title('Checked Coupon Status Page', true);
        return $this->render('admin/coupon/status', array('merchants' => array()));
    }

    /**
     * @Clips\Form("admin/coupon/record")
     * @Clips\Widgets\DataTable({"admin_coupon_record"})
     * @Clips\Widget({"grid", "bootstrap","datepicker", "image", "yizhifushim"})
     * @Clips\Scss("admin/coupon/record")
	 * @Clips\Model({"merchantProduct", "user", "merchant"})
     */
    public function record(){
		$this->title('Checked Coupon Record Page', true);
	    \Clips\context('jquery_init', <<<ACTION_JS
			linkSelect('#field_branch', '#field_group_purchase');

            function admin_coupon_record_datatable_action(data, type, row, col, meta){
                var action_url = Clips.siteUrl(col.action) +row[col.refer];
                var start_time = $("#field_start_time").val();
                var end_time = $("#field_end_time").val();
                if(start_time)
                    action_url += "&start_time="+start_time;
                if(end_time)
                    action_url += "&end_time="+end_time;
                return "<a href='"+ action_url +"'>"+ data +"</a>"
            }


ACTION_JS
		, true);
		$p = array();
		if($this->post('group_purchase') && $this->post('group_purchase')!='~'){
			$p['products.id'] = $this->post('group_purchase');
		}
		if($this->post('start_time')){
			$this->request->session('start_time', $this->post('start_time'));
			$p[] = new \Clips\Libraries\CommonOperator('customer_products.timestamp', $this->post('start_time'), '>=');
		}
		if($this->post('end_time')){
			$this->request->session('end_time', $this->post('end_time'));
			$p[] = new \Clips\Libraries\CommonOperator('customer_products.timestamp', $this->post('end_time').' 23:59:59', '<=');
		}
	    if($this->post('branch') && $this->post('branch')!='~') {
		    $p['merchant_products.mid'] = $this->post('branch');
		    $this->request->session('branch', $this->post('branch'));
	    }
//	    var_dump($this->post('group_purchase'),$this->post('branch'));
		$this->formData("admin/coupon/record",(object)$this->post());

		$mid = $this->merchant->getCurrentMerchantID();
	    if($this->request->session('branch')) {
		    $p[] = array('merchant_products.mid' => $this->request->session('branch'));
	    }else{
		    $p[] = array('merchant_products.mid' => $mid);
	    }
	    $parentID = $this->merchant->getParentID($mid);
	    $merchant = $this->merchant->one('id',$mid);
	    if($parentID) {
		    $merchants[0] = $merchant;
		    // $merchants = $this->merchant->getMerchantsByParentID($parentID);
		    // array_unshift($merchants,$merchant);
	    }else{
		    $merchants = $this->merchant->getMerchantsByParentID($mid);
		    array_unshift($merchants,$merchant);
	    }

//	    foreach ($merchants as $k=>$v) {
//			$products = $this->merchantproduct->getMerchantProducts($v->id);
//		    $merchants[$k]->products = $products;
//	    }

		$please_select = $this->bundle->message('-- All --');
	    $this->request->session('admin_coupon_record', $p);
		return $this->render('admin/coupon/record', array('merchants'=>$merchants, 'prepend'=>array($please_select=> '')));
    }


	/**
	 * @Clips\Model({"customerProduct", "order","merchant"})
	 */
	public function code(){
		$code = $this->post('coupon_code');
		$now = new \DateTime();
		$coupon = $this->customerproduct->getByCode($code);
		if(isset($coupon->id)) {
			$is_active = ($coupon->status == "ACTIVE");
			$order = $this->order->getOrderByItemID($coupon->item_id)[0];
			if($order->status == 'NOPAY' || $order->status == 'USERCANCELLED'||$order->expire_date<=$now->format('Y-m-d H:i:s')) {
				$useable = false;
			}else{
				$useable = true;
			}
			$mid = $order->mid;
			$current_mid = $this->merchant->getCurrentMerchantID();
//			var_dump($mid,$current_mid);
			if($mid != $current_mid) {
				$useable = false;
			}
		}else{
			$is_active = $useable = false;
		}

		if($is_active && $useable ) {
			echo json_encode(array('success' => true, 'msg' => "\"$code\" " . $this->bundle->message($coupon->status)));
		}else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('This code is invalid!')));
		}
	}

    /**
     * @Clips\Form("admin/coupon/lists")
     * @Clips\Widgets\DataTable("admin_coupon_lists")
     * @Clips\Widget({"grid", "bootstrap","datepicker", "image", "yizhifushim"})
     * @Clips\Scss("admin/coupon/lists")
	 * @Clips\Model({"merchantProduct", "user", "merchant"})
     */
    public function lists() {
		$this->title('Checked Coupon Record Detail Page', true);
		$this->formData("admin/coupon/lists",(object)$this->get());
	    $mid = $this->merchant->getCurrentMerchantID();
	    $group_purchase = trim($this->get('group_purchase'),'/');
		$p = array('customer_products.product_id' => $group_purchase);
	    if($this->request->session('branch')) {
	        $p[] = array('merchant_products.mid' => $this->request->session('branch'));
	    }else{
		    $p[] = array('merchant_products.mid' => $mid);
	    }
		if($this->request->session('start_time')){
			$p[] = new \Clips\Libraries\CommonOperator('customer_products.timestamp', $this->request->session('start_time'), '>=');
		}
		if($this->request->session('end_time')){
			$p[] = new \Clips\Libraries\CommonOperator('customer_products.timestamp', $this->request->session('end_time').' 23:59:59', '<=');
		}
		$this->request->session('admin_coupon_lists', $p);
		$products = $this->merchantproduct->getMerchantProducts($mid);
		return $this->render('admin/coupon/lists', array('products'=>$products));
    }
} 