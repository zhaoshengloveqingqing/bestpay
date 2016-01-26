<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\BaseController;

	/**
	* @Clips\MessageBundle(name="people")
	* @Clips\Widget({"html", "lang", "grid", "image", "navigation", "bootstrap","form", "yizhifu"})
	* @Clips\Context(key = 'test_data', value = 'navigation')
	* @Clips\Object('testData')
	*/
class PeopleController extends BaseController {
	/**
	* @Clips\Model({"tag", "category","user","cart"})
	* @Clips\Widgets\ListView("people_index")
	* @Clips\Scss("people/index")
	* @Clips\Form('people/index')
	* @Clips\Js("application/static/js/people/people.js")
	*/
	public function index() {
		$this->title('People Page',true);
		$render_data = array();
		$area = $this->tag->getTagByName('宅生活');
//		if($area){
//			$level = $this->tag->getMaxLevel($area->id);
//			for($i=$area->level+1; $i<=$level;$i++){
//				$render_data['tag'.$i] = $this->tag->getTagsByLevel($i, $area->id);
//			}
//		}
		$p = array('products.category_id' => $this->category->getProductID());
		if(true){
			$this->request->session('mall_index', $p);
		}
		$data = json_encode($this->tag->getTags($area));
		$js = <<<TEXT
	var layer = $('ul.layer');
	var api = $('#people_index').data('api');
	var ds = new Clips.DataSource($data);
	$("#people_index").on('list.init', function(e, list){
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
//		li.parent().parent().parent().find('h3').hide();
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
		return $this->render('people/index', $render_data);
	}
}
