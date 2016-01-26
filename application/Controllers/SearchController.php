<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\BaseController;

/**
 * @Clips\MessageBundle(name="search")
 * @Clips\Widget({"html", "lang", "grid", "image", "navigation", "bootstrap","form", "yizhifu"})
 * @Clips\Context(key = 'test_data', value = 'navigation')
 * @Clips\Object('testData')
 */
class SearchController extends BaseController {
	/**
	 * @Clips\Model({"product"})
	 * @Clips\Widgets\ListView("mall_index")
	 * @Clips\Scss("search/index")
	 */
	public function search()
	{
		$key = $this->post('key');
//		$this->request->session('search_key',$key);
		$products = $this->product->getProductsByKey($key);
		return $this->render('search/index',array('products'=>$products,'key'=>$key));
	}
}