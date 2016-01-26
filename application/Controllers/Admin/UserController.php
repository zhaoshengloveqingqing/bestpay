<?php namespace Pinet\BestPay\Controllers\Admin; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Controller;

/**
 * The main controller for all the user operations
 *
 * @author Jack
 * @date Tue Feb 24 16:07:01 2015
 *
 * @Clips\Widget({"lang", "grid"})
 * @Clips\MessageBundle(name="admin")
 */
class UserController extends Controller {

	/**
	 * @Clips\Widgets\DataTable("admin_user_home")
	 */
	public function index() {
		return $this->render('admin/user/home');
	}

	/**
	 * @Clips\Form('admin/user_create')
	 */
	public function create() {
		return $this->render('admin/user/create');
	}

	/**
	 * @Clips\Model("user")
	 * @Clips\Form('admin/user_create')
	 */
	public function create_form() {
		$this->user->insert($this->user->cleanFields('users', $this->post()));
		return $this->redirect(\Clips\site_url('admin/user'));
	}	

	/**
	 * @Clips\Form("admin/user_coupon")
	 * @Clips\Widget({"grid", "bootstrap", "image"})
	 * @Clips\Scss("admin/user/coupon")
   	 * @Clips\Model("merchant")
	 * @Clips\Js("application/static/js/user/coupon.js")
	 */
	public function coupon() {
		$this->title('Check Coupon Page', true);
		return $this->render('admin/user/coupon', array('merchants' => $this->merchant->getMerchants($this->request->session('user_id'))));
	}

	/**
	 * @Clips\Model("userCoupon")
	 */
	public function validate_code(){
		$result = $this->usercoupon->useCode($this->post('coupon_code'));
		if($result)
			echo json_encode(array('success'=>true, 'msg'=>$this->bundle->message('Validate code successfully!')));
		else{
			echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('This code is invalid!')));
		}
	}

	/**
	 * @Clips\Form("admin/user_coupon_status")
	 * @Clips\Widget({"grid", "bootstrap", "image"})
	 * @Clips\Scss("admin/user/coupon_status")
	 * @Clips\Model("userCoupon")
	 * @Clips\Js("application/static/js/user/coupon_status.js")
	 */
	public function coupon_status() {
       		$this->title('Coupon Voucher Status', true);
		return $this->render('admin/user/coupon_status');
	}

	/**
	 * @Clips\Model("userCoupon")
	 */
public function search_code(){
	$code = $this->post('coupon_code');
	$coupon = $this->usercoupon->getByCode($code);
	if(isset($coupon->id))
		echo json_encode(array('success'=>true, 'msg'=> "\"$code\" ".$this->bundle->message($coupon->status)
		.', '.$this->bundle->message('Expired date').': ' . $coupon->expire_date));
	else{
		echo json_encode(array('success'=>false, 'msg'=>$this->bundle->message('This code is invalid!')));
	}
}

//    public function admin_coupon_record_pagination(){
//        $p = $this->getPagination('admin_coupon_record');
//        $p->where = array_merge(array('products.id'=>'1') , $p->where);
//        return $this->processPagination($p);
//    }
	
	/**
	 * @Clips\Form("admin/coupon_record")
	 * @Clips\Widget({"grid", "bootstrap", "image","datatable","form", "datepicker", "yizhifushim"})
	 * @Clips\Widgets\DataTable("admin_coupon_record")
	 * @Clips\Scss("admin/user/coupon_record")
	 * @Clips\Js("application/static/js/user/coupon_record.js")
	 * @Clips\Model("product")
	 */
	public function coupon_record() {
        $this->title('Checked Coupon Record Page', true);
        \Clips\add_init_js(
            <<<ACTION_JS
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
        );//TODO
        $uid = $this->request->session('user_id');
        $p = array('merchants.uid' => $uid);
        if($this->post('group_purchase')){
            $p['products.id'] = $this->post('group_purchase');
        }
        if($this->post('start_time')){
            $p[] = new \Clips\Libraries\CommonOperator('user_coupons.timestamp', $this->post('start_time'), '>=');
        }
        if($this->post('end_time')){
            $p[] = new \Clips\Libraries\CommonOperator('user_coupons.timestamp', $this->post('end_time'), '<=');
        }
        $this->formData("admin/coupon_record",(object)$this->post());
        $this->request->session('admin_coupon_record', $p);
        $products = $this->product->getProductsByUID($uid);
        $please_select = $this->bundle->message('-- All --');
		return $this->render('admin/user/coupon_record', array('products'=>$products, 'prepend'=>array($please_select=> '')));
	}

//    public function admin_merchant_coupon_record_pagination(){
//        $p = $this->getPagination('admin_merchant_coupon_record');
//        $p->where = array_merge(array('coupons.product_id'=>'1') , $p->where);
//        return $this->processPagination($p);
//    }

	/**
	 * @Clips\Form("admin/merchant_coupon_record")
	 * @Clips\Widget({"grid", "bootstrap", "image","datatable", "datepicker", "yizhifushim"})
	 * @Clips\Widgets\DataTable("admin_merchant_coupon_record")
	 * @Clips\Scss("admin/user/merchant_coupon_record")
	 * @Clips\Model("product")
	 */
	public function merchant_coupon_record() {
		$this->title('Checked Coupon Record Detail Page', true);
		$this->formData("admin/merchant_coupon_record",(object)$this->get());
		$p = array('coupons.product_id' => $this->get('group_purchase'));
		if($this->get('start_time')){
			$p[] = new \Clips\Libraries\CommonOperator('user_coupons.timestamp', $this->get('start_time'), '>=');
		}
		if($this->get('end_time')){
			$p[] = new \Clips\Libraries\CommonOperator('user_coupons.timestamp', $this->get('end_time'), '<=');
		}
		$this->request->session('admin_merchant_coupon_record', $p);
		$products = $this->product->getProductsByUID($this->request->session('user_id'));
		return $this->render('admin/user/merchant_coupon_record', array('products'=>$products));
	}

	/**
	 * @Clips\Form("admin/user_add_merchant")
	 * @Clips\Widget({"grid", "bootstrap", "image"})
	 * @Clips\Scss("admin/home")
	 */
	public function add_merchant() {
		$this->title('Merchant Register', true);
		return $this->render('admin/user/add_merchant', array('header' => 'Admin Home'));
	}

	/**
	 * @Clips\Widgets\DataTable("admin_merchant")
	 * @Clips\Form("admin/user_add_merchant")
	 * @Clips\Model({"userInfo","user","merchant"})
	 * @Clips\Form('admin/user_add_merchant')
	 * @Clips\Scss("admin/home")
	 * @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	 *
	 */
public function add_merchant_form() {
	if($this->post('password') != $this->post('password_confirm')){
		echo "<script>alert('password and password_confirm is different!');location.href='#';</script>";
		return $this->render('admin/user/add_merchant');
	}
	$now = new \DateTime();
	$uid=$this->user->insert($this->user->cleanFields('users', array(
	'status'=>'ACTIVE',
	'create_date'=> $now->format('Y-m-d H:i:s'),
	'timestamp'=> $now->format('Y-m-d H:i:s')

	)));
	if($uid==null){
		echo "<script>alert('user id can not be null!');location.href='#';</script>";
	}

	$result= $this->userinfo->insert($this->userinfo->cleanFields('user_infos', array(
	'uid'=>$uid,
	'username'=>$this->post('username'),
	'password'=>\Clips\password($this->post('password')),
	'create_date'=> $now->format('Y-m-d H:i:s'),
	'timestamp'=> $now->format('Y-m-d H:i:s')
	)));
	$this->request->session('user_id',$result);
	$res= $this->merchant->insert($this->merchant->cleanFields('merchants', array(
	'uid'=>$uid,
	'name'=>$this->post('username'),
	'status'=>'ACTIVE',
	'create_date'=> $now->format('Y-m-d H:i:s'),
	'timestamp'=> $now->format('Y-m-d H:i:s')
	)));
	if($res==null){
		echo "<script>alert('merchant id can not be null!');location.href='#';</script>";
	}
	if(is_numeric($result)){
		return $this->redirect(\Clips\site_url('admin/user/merchant'));
	}else{
		echo "<script>alert('username or password can not be correct!');location.href='login';</script>";
	}
}
	/**
	 * @Clips\Widget({"grid", "bootstrap", "image","datatable", "datepicker", "yizhifushim"})
	 * @Clips\Widgets\DataTable("admin_merchant")
	 * @Clips\Scss("admin/user/merchant_coupon_record")
	 * @Clips\Model("product")
	 */
	public function merchant(){
		$this->title('Merchant List', true);
		return $this->render('admin/user/merchant');
	}
	/**
	 * @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	 * @Clips\Form("admin/user_modify_merchant")
	 * @Clips\Model({"userInfo","user","merchant"})
	 * @Clips\Widget({"grid", "bootstrap", "image"})
	 * @Clips\Scss("admin/home")
	 */
	public function modify_merchant($id){
		$this->title('Merchant List', true);
		$userinfos=$this->userinfo->getUserInfo($id);
		$this->formData("admin/user_modify_merchant",(object)$userinfos);
		return $this->render('admin/user/modify_merchant',array('userinfos'=>$userinfos,'id'=>$id));
	}

	/**
	 * @Clips\Form("admin/user_modify_merchant")
	 * @Clips\Model({"userInfo","user","merchant"})
	 * @Clips\Form('admin/user_add_merchant')
	 * @Clips\Scss("admin/home")
	 * @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	 */
	public function modify_merchant_form(){
		$this->userinfo->updateInfo($this->request->post(),\Clips\password($this->request->post('password')));
		return $this->redirect(\Clips\site_url('admin/user/merchant'));
	}

	/**
	 * @Clips\Model({"userInfo","user","merchant"})
	 * @Clips\Scss("admin/user/orders")
	 * @Clips\Widgets\ListView("admin_user_orders")
	 * @Clips\Widget({"grid", "image", "bootstrap", "owlcarousel",  "yizhifu"})
	 */
	public function orders(){
		$this->title('My Order Page',true);
		$uid = $this->user->getCurrentUserId();
		$p[] = array('merchants.id' => $uid,'product_photos.is_primary'=>'1');
		$p[] = new \Clips\Libraries\CommonOperator('orders.status', 'DELETE', '!=');
		//自定义查询
		$this->request->session('admin_user_orders', $p);
		return $this->render('admin/user/orders');
	}



}
