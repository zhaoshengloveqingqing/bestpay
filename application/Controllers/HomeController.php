<?php namespace Pinet\BestPay\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\BestPay\Core\BaseController;

	/**
	* @Clips\MessageBundle(name="home")
	* @Clips\Widget({"html", "lang", "grid", "image", "bootstrap","navigation","form", "yizhifu"})
	*/
class HomeController extends BaseController {

	/**
	* @Clips\Model({"product","orderItem","tag","category","cart","user"})
	* @Clips\Widgets\ListView({"home_mall", "home_coupon", "home_car", "home_people"})
	* @Clips\Widget({"slider", "jdatagrid"})
	* @Clips\Js({"application/static/js/home/index.js"})
	* @Clips\Scss("home/index_mobile")
	* @Clips\Form('home/index')
	*/
    public function index() {
//	    * @Clips\Scss("home/index")
//	    var_dump($_SESSION);die;
		$this->title('Pinet Home Page',true);
	    $now = new \DateTime();
	    $nowDate = $now->format('Y-m-d H:i:s');
	    $p[] = new \Clips\Libraries\CommonOperator('products.expire_date', $nowDate, '>');
	    $this->request->session('home_mall', $p);
	    $area = $this->tag->getTagByName('惠生活');
	    $cid = $this->category->getProductID();
	    $tag_id = $area->id;
	    $args['benefit'] = $this->product->getMallProductByTag($cid,$tag_id);
	    $args['news'] = $this->product->getNewProductByTag($cid,$tag_id);
	    $args['rec'] = $this->product->getRecProductByTag($cid,$tag_id);
	    $args['low_price'] = $this->product->getProductByLowPrice($cid,$tag_id);
	    $args['congregation'] = $this->product->getNewProductByLast($cid,$tag_id);

	    //$args['coupon'] = $this->product->getCoupons();
		//$args = array('products'=>$this->product->getCoupons());
	    $area = $this->tag->getTagByName('券生活');
	    $cid = $this->category->getCouponCategoryId();
	    $tag_id = $area->id;
	    $args['coupon'] = $this->product->getProductByTag($cid,$tag_id);
	    $args['car'] = array(
			    (object)array('path'=> './lvyinge/concept_car.jpg', 'price' => '￥100', 'intro' => '开发中'),
			    (object)array('path'=> './lvyinge/concept_car.jpg', 'price' => '￥50', 'intro' => '开发中'),
			    (object)array('path'=> './lvyinge/concept_car.jpg', 'price' => '￥500', 'intro' => '开发中'),
			    (object)array('path'=> './lvyinge/concept_car.jpg', 'price' => '￥600', 'intro' => '开发中')
	    );
	    $args['servicetop'] = array(
//			    (object)array('imgsrc'=> 'home_banner.png'),
			    (object)array('imgsrc'=> 'home_jiazhuang.png'),
			    (object)array('imgsrc'=> 'home_jiazheng.png'),
			    (object)array('imgsrc'=> 'home_banjia.png'),
			    (object)array('imgsrc'=> 'home_jiadian.png'),
			    (object)array('imgsrc'=> 'home_kaisuo.png'),
			    (object)array('imgsrc'=> 'home_baojie.png'),
	    );
	    $args['service'] = array(
//			    (object)array('imgsrc'=> 'home_banner.png'),
			    (object)array('imgsrc'=> 'home_jiazheng.png'),
			    (object)array('imgsrc'=> 'home_jiazhuang.png'),
			    (object)array('imgsrc'=> 'home_jiadian.png'),
			    (object)array('imgsrc'=> 'home_banjia.png'),
			    (object)array('imgsrc'=> 'home_baojie.png'),
			    (object)array('imgsrc'=> 'home_kaisuo.png'),
			    (object)array('imgsrc'=> 'home_shutong.png'),
			    (object)array('imgsrc'=> 'home_kuaidi.png')
	    );
	    $args['items'] = array(
			    (object) array('url'=>'application/static/img/deli/home/home-banner1.jpg'),
			    (object) array('url'=>'application/static/img/deli/home/home-banner2.jpg'),
			    (object) array('url'=>'application/static/img/deli/home/home-banner3.jpg')
	    );

	    $args['left_one'] = array(
			    (object) array('url'=>'application/static/upload/img/lvyinge/banner_news_1.jpg'),
			    (object) array('url'=>'application/static/upload/img/lvyinge/banner_news_2.jpg')
	    );
	    $args['left_two'] = array(
			    (object) array('url'=>'application/static/upload/img/lvyinge/banner_mall_1.jpg'),
			    (object) array('url'=>'application/static/upload/img/lvyinge/banner_mall_2.jpg')
	    );
	    $args['left_three'] = array(
			    (object) array('url'=>'application/static/upload/img/lvyinge/banner_coupon_1.jpg'),
			     (object) array('url'=>'application/static/upload/img/lvyinge/banner_mall_1.jpg')
	    );
	    $args['left_four'] = array(
			    (object) array('url'=>'application/static/upload/img/lvyinge/banner_car_1.jpg'),
			    (object) array('url'=>'application/static/upload/img/lvyinge/banner_car_2.jpg')
	    );
	    $args['left_five'] = array(
			    (object) array('url'=>'application/static/upload/img/lvyinge/banner_people_1.jpg'),
			    (object) array('url'=>'application/static/upload/img/lvyinge/banner_people_2.jpg')
	    );
	    if($this->request->isMobile()){
		    return $this->render('home/index_mobile');
	    }
	    else {
		    return $this->render('home/index', $args);
	    }
    }
}
