<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\BaseController;

	/**
	* @Clips\MessageBundle(name="mall")
	* @Clips\Widget({"html", "lang", "grid", "image", "navigation", "bootstrap","form", "yizhifu"})
	* @Clips\Context(key = 'test_data', value = 'navigation')
	* @Clips\Object('testData')
	*/
class MallController extends BaseController {

	/**
	* @Clips\Model({"tag", "category","user","cart","orderItem"})
	* @Clips\Widgets\ListView("mall_index")
	* @Clips\Scss("mall/index")
	* @Clips\Form('mall/index')
	* @Clips\Js("application/static/js/mall/mall.js")
	*/
	public function index() {
		$this->title('Mall Page',true);
		$now = new \DateTime();
		$area = $this->tag->getTagByName('惠生活');
		if($area){
//			$level = $this->tag->getMaxLevel($area->id);
//			for($i=$area->level+1; $i<=$level;$i++){
//				$render_data['tag'.$i] = $this->tag->getTagsByLevel($i, $area->id);
//			}
		}

		$p = array('products.category_id' => $this->category->getProductID());
		$p[] = new \Clips\Libraries\CommonOperator('products.expire_date', $now->format('Y-m-d H:i:s'), '>=');

		$this->request->session('mall_index', $p);

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
		return $this->render('mall/index');
	}

	/**
	 * @Clips\Model("tag","cart")
	 */
	public function index_ajax() {
		$path = $this->request->param('path');
		$level = $this->request->param('level', null);
		$ret = array();
		if($level !== null) {
			if ($path) {
				return $this->json(array('layer' => $this->tag->select("id", "name", "level as layer", "path")->from("tags")->where(array(
						'level' => $level,
						new \Clips\Libraries\LikeOperator("path", $path . "%")
				))->result()));
			} else {
				return $this->json(array('layer' => $this->tag->select("id", "name", "level as layer", "path")->from("tags")->where(array(
						'level' => $level
				))->result()));
			}
		}
	}
}