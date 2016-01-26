<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\BaseController;

/**
 * @Clips\Widget({"html", "lang", "grid", "image", "navigation", "bootstrap","form", "yizhifu"})
 * @Clips\MessageBundle(name="car")
 * @Clips\Context(key = 'test_data', value = 'navigation')
 * @Clips\Object('testData')
 */
class CarController extends BaseController {

	/**
	* @Clips\Model({"tag", "category","cart","user"})
	* @Clips\Widgets\ListView("car_index")
	* @Clips\Scss("car/index")
	* @Clips\Form('car/index')
	* @Clips\Js("application/static/js/mall/mall.js")
	*/
	public function index() {
		$this->title('Car Page',true);
		$render_data = array();
		$area = $this->tag->getTagByName('车生活');
		$p = array('products.category_id' => $this->category->getProductID());
		if(true){
			$this->request->session('mall_index', $p);
		}
		$data = json_encode($this->tag->getTags($area));
		$js = <<<TEXT
	var layer = $('ul.layer');
	var api = $('#mall_index').data('api');
	var ds = new Clips.DataSource($data);
	$("#mall_index").on('list.init', function(e, list){
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
//		li.parent().parent().parent().find('p').addClass('show');
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
		return $this->render('car/index', $render_data);
	}

}
