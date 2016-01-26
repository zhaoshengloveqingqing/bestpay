<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\BaseController;

	/**
	* @Clips\MessageBundle(name="coupon")
	* @Clips\Widget({"html", "lang", "grid", "image", "bootstrap","navigation", "yizhifu"})
	* @Clips\Context(key = 'test_data', value = 'navigation')
	* @Clips\Object('testData')
	*/
class CouponController extends BaseController {
	/**
	* @Clips\Model({"tag", "category","user","cart"})
	* @Clips\Widgets\ListView("coupon_index")
	* @Clips\Scss("coupon/index")
	* @Clips\Form('coupon/index')
	* @Clips\Js("application/static/js/mall/mall.js")
	*/
	public function index(){
		$this->title('Coupon Page',true);
		$render_data = array();
		$area = $this->tag->getTagByName('券生活');
		if($area){
//			$level = $this->tag->getMaxLevel($area->id);
//			for($i=$area->level+1; $i<=$level;$i++){
//				$render_data['tag'.$i] = $this->tag->getTagsByLevel($i, $area->id);
//			}
		}
		$now = new \DateTime();
		$p = array('products.category_id' => $this->category->getCouponCategoryId());
		$p[] = new \Clips\Libraries\CommonOperator('products.expire_date', $now->format('Y-m-d H:i:s'), '>=');
		$this->request->session('coupon_index', $p);
		$data = json_encode($this->tag->getTags($area));
$js = <<<TEXT
	var layer = $('ul.layer');
	var api = $('#coupon_index').data('api');
	var ds = new Clips.DataSource($data);
	$("#coupon_index").on('list.init', function(e, list){
		api.clearSearch(list);
	});
	layer.each(function(){
		new Clips.Layer(ds, this);
	});
	layer.on('click', 'li.active',  function(e){
		var li = $(e.currentTarget);
		var path = li.data('id');
		var id = path.split('/');
		id.pop();
		id = id.pop();
		api.columnSearch(1, id);
	});
	layer.on('list.tags.init-active', function(e, ul){
		$(ul.node).parent().addClass('show');
	});
	layer.on('list.tags.refresh', function(e, ul){
		$(ul.node).parent().removeClass('show');
	});
	layer.on('list.tags.always-active', function(e, ul){
		$(ul.node).parent().addClass('show');
	});
TEXT;
		\Clips\clips_context('jquery_init', $js, true);
					return $this->render('coupon/index');
	}
}