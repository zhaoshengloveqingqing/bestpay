<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\BaseController;

	/**
	* @Clips\Widget({"html", "lang", "grid", "image", "bootstrap", "navigation","form","yizhifu"})
	* @Clips\MessageBundle(name="help")
	* @Clips\Context(key = 'test_data', value = 'navigation')
	* @Clips\Object('testData')
	*/
class HelpController extends BaseController {
	/**
	* @Clips\Model({"help"})
	* @Clips\Scss("help/index")
	*/
	public function index() {
		return $this->render('help/index');
	}

	/**
	 * @Clips\Widget({"grid", "image", "bootstrap", "yizhifu"})
	 * @Clips\Scss("help/introduction")
	 */
	public function introduction(){
		return $this->render('help/introduction');
	}
}
