<?php namespace Pinet\BestPay\Libraries; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

/**
 * The fake data generator
 *
 * @author Jake
 * @since 2/28/15 11:25 AM
 * @Clips\Model({"user","merchant","group","groupUser","userInfo","product"})
 * @Clips\Model({"category","coupon","userCoupon", "payment", "order", "orderItem"})
 * @Clips\Object({"FakeData"})
 */
class FakeProjectData implements \Psr\Log\LoggerAwareInterface {

    private $payment_id = 1000;
    private $merchant_id = 1000;
    private $merchant_group_id = 1000;
    private $user_group_id = 2000;
    private $category_id = 1000;
    private $coupon_category_id = 2000;
    private $products = array();
    private $uids = array();
    private $coupons = array();

    public function setLogger(\Psr\Log\LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function do_fake(){
        $this->fake_payment();
        $this->fake_group();
        $this->fake_category();
        $this->fake_user();
        $this->fake_order();
    }

    public function fake_user(){
        $now = new \DateTime();
        for($i=0;$i<10;$i++){
            $uid = $this->user->insert(array(
                'create_date' => $now->format('Y-m-d H:i:s')
            ));
            if($i==0){
                $this->groupuser->insert(array(
                    'uid' => $uid,
                    'gid' => $this->merchant_group_id
                ));
                $mid = $this->merchant->insert(array(
                    'id' => $this->merchant_id,
                    'uid' => $uid,
                    'name' => 'Pinet Group Coupon',
                    'is_main_store' => '1',
                    'create_date' => $now->format('Y-m-d H:i:s')
                ));
                $this->fake_product($mid);
            }else{
                $this->uids[] = $uid;
                $this->groupuser->insert(array(
                    'uid' => $uid,
                    'gid' => $this->user_group_id
                ));
                $this->fake_user_coupon($uid);
            }
            $name = $this->fakedata->fakeName();
            if($i==0){
                $name->simple_name = 'pinet_suzhou';
            }
            $this->userinfo->insert(array(
                'uid' => $uid,
                'username' => $name->simple_name,
                'password' => \Clips\password('password'),
                'first_name' => $name->first_name,
                'last_name' => $name->last_name,
                'email_address' => $this->fakedata->fakeEmail($name->simple_name),
                'create_date' => $now->format('Y-m-d H:i:s')
            ));
        }
    }

    public function fake_group(){
        $this->group->insert(array(
            'id'=>$this->merchant_group_id,
            'name'=>'merchant'
        ));
        $this->group->insert(array(
            'id'=>$this->user_group_id,
            'name'=>'user'
        ));
    }

    public function fake_category(){
        $now = new \DateTime();
        $this->category->insert(array(
            'id' => $this->category_id,
            'parent_id' => 0,
            'name' => 'Coupon',
            'type' => 'coupon',
            'create_date' => $now->format('Y-m-d H:i:s'),
        ));

        $this->category->insert(array(
            'id' => $this->coupon_category_id,
            'parent_id' => 0,
            'name' => '促销',
            'type' => '促销',
            'create_date' => $now->format('Y-m-d H:i:s'),
        ));
    }

    public function fake_product($mid){
        $now = new \DateTime();
        $f = new \DateTime();
        for($i=0;$i<10;$i++){
            $f->add(\DateInterval::createFromDateString('1 month'));
            $pid = $this->product->insert(array(
                'merchant_id' => $mid,
                'category_id' => $this->category_id,
                'name' => 'Coupon Product ' . ($i+1),
                'price' => rand(2000, 9000),
                'discount_price' => rand(200, 900),
                'amount' => rand(20000, 90000),
                'expire_date' => $f->format('Y-m-d H:i:s'),
                'create_date' => $now->format('Y-m-d H:i:s')
            ));
            $this->products[] = $pid;
            $this->coupons[] = $this->coupon->insert(array(
                'product_id' => $pid,
                'category_id' => $this->coupon_category_id,
                'name' => '随便叫，随便卖 ' . ($i+1),
                'price' => rand(20,60),
                'amount' => rand(200,600),
                'expire_date' => $f->format('Y-m-d H:i:s'),
                'create_date' => $now->format('Y-m-d H:i:s')
            ));
        }
    }

    public function fake_user_coupon($uid){
        $c = count($this->coupons);
        $arr_status = array('ACTIVE', 'USED');
        for($j=0;$j<50;$j++){
            $now = new \DateTime();
            $f = new \DateTime();
            $t = new \DateTime();
            $f->add(\DateInterval::createFromDateString('1 month'));
            for($i=0;$i<$c;$i++){
                $s = rand(0,1);
                $rt = rand(-60, 60);
                $t->add(\DateInterval::createFromDateString("$rt days"));
                $this->usercoupon->insert(array(
                    'coupon_id' => $this->coupons[$i],
                    'uid' => $uid,
                    'code' => rand(9999999999, 99999999999),
                    'status' => $arr_status[$s],
                    'expire_date' => $f->format('Y-m-d H:i:s'),
                    'create_date' => $now->format('Y-m-d H:i:s'),
                    'timestamp' => $t->format('Y-m-d H:i:s')
                ));
            }
        }
    }

    public function fake_payment(){
        $now = new \DateTime();
        $this->payment->insert(array(
            'id' => $this->payment_id,
            'name' => '翼支付',
            'code' => 'bestpay',
            'create_date' => $now->format('Y-m-d H:i:s')
        ));
    }

    public function fake_order(){
        for($i=0;$i<200;$i++){
            $now = new \DateTime();
            $pc = count($this->products);
            $uc = count($this->uids);
            $p = rand(0,$pc);
            $u = rand(0,$uc);
            for($j=$p;$j<$pc;$j++){
                for($k=$u;$k<$uc;$k++){
                    $uid = $this->uids[$k];
                    $oid = $this->order->insert(array(
                        'uid' => $uid,
                        'name' => '随机测试订单 ' . rand(5000, 60000),
                        'order_number' => rand(9999999999, 99999999999),
                        'payment_id' => $this->payment_id,
                        'create_date' => $now->format('Y-m-d H:i:s')
                    ));
                    $this->fake_order_item($oid, $this->products[$j], $uid);
                }
            }
        }
    }

    public function fake_order_item($oid, $pid, $uid){
        $r = rand(0,5);
        for($i=0; $i<=$r; $i++){
            $now = new \DateTime();
            $this->orderitem->insert(array(
                'order_id' => $oid,
                'uid' => $uid,
                'product_id' => $pid,
                'amount' => rand(1,5),
                'price' => rand(50,900),
                'create_date' => $now->format('Y-m-d H:i:s')
            ));
        }
    }
}
