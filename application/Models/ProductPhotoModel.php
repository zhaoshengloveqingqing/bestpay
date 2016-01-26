<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table product_photos
 *
 * @author Jack
 * @version 1.0
 * @date Sun Mar 15 12:08:08 2015
 *
 * @Clips\Model
 */
class ProductPhotoModel extends DBModel {

    public function getProductPhotos($product_id) {
        return $this->select('*')->from($this->table)->where(array('product_id' => $product_id))
            ->orderby('rand()')->result();
    }
}
