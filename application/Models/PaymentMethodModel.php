<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table payment_methods
 *
 * @author Jack
 * @version 1.0
 * @date Sun Mar 15 12:08:08 2015
 *
 * @Clips\Model
 */
class PaymentMethodModel extends DBModel {
    public function getPayment($code){
        if(!$code){
            return array();
        }
        return $this->get(array(
            'code' => $code
        ));
    }
}
