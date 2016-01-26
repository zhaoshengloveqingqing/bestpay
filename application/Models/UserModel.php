<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table users
 *
 * @author Jack
 * @version 1.0
 * @date Sun Mar 15 12:08:08 2015
 *
 * @Clips\Model({"user","customer"});
 * @Clips\Library({"encryptor", "curl"})
 */
class UserModel extends DBModel {

	/**
	 * Get current user's id from session
	 *
	 * @return user_id
	 * 		The id of current user, if user is not logged in, the will be false
	 */
	public function getCurrentUserId() {
		$request = \Clips\context('request');
		if($request) {
			return $request->session('user_id');
		}
		else {
			\Clips\error('Trying to get user\'s login infor when no request is there.');
		}
		return false;
	}

	public function setCurrentUserID($uid){
		$request = \Clips\context('request');
		$request->session('user_id',$uid);
	}

	public function isCustomer($id) {
		// TODO: Add check using customer table
		return true;
	}

    public function addUser($id){
        $request = \Clips\context('request');
        $now = new \DateTime();
        $data['id'] = $id;
        $data['create_date'] = $now->format('Y-m-d H:i:s');
        $uid = $this->insert($data);
        if($uid)
            $request->session('user_id', $uid);
        return $uid;
    }

	public function isRegister($getToken){
		$request = \Clips\context('request');
		if($getToken) {
			$token = json_decode($this->encryptor->publicDecrypt($getToken));
			$users = $this->load($token->uid);
			if (isset($token->uid)) {
				if (isset($users->id)) {
					$request->session('user_id', $users->id);
					$this->curl->get("http://user.pinet.co/api/get_user_data", array('token' =>$getToken));
					if($this->curl->http_status_code == 200) {
						$response = json_decode($this->curl->response);
					}
					if($request)
					    $request->session('bestpay_username',$response->username);
						$request->session('user_infos',$response);
						return $users->id;
				}
			}
		}
	}

	public function finishRegister($post,$token){
		$request = \Clips\context('request');
		if($post['uid']){
			$uid = $this->addUser($post['uid']);
		}
		$customer = $this->customer->one(array('uid'=>$post['uid']));
		if(!$customer){
			$this->customer->addCustomer($post,$uid);
		}
		$this->curl->post("http://user.pinet.co/api/update_basic_info", array(
				'token' =>$token,
				'username' =>$post['username'],
				'password' =>md5($post['password']),
				'first_name' => $post['first_name'],
				'last_name' => $post['last_name'],
				'sex' => $post['sex'],
				'mobile' => $post['mobile'],
				'email' => $post['email']
		));
		if($this->curl->http_status_code == 200) {
			$response = json_decode($this->curl->response);
			$request->session('bestpay_username',$post['username']);
		}
		return $response->success;
	}

	public function deliveryAddressByUid($uid){
		return $this->customer->get(array(
				'uid'=> $uid,
				'status'=>null
		));
	}

	public function getMyAddressByCid($cid){
		return $this->customer->one(array(
				'id'=> $cid,
				'status'=>null
		));
	}

	public function getDefaultAddress($uid){
		$where['customers.status']=null;
		$where['customers.uid'] =$uid;
		$where['customers.default_address'] ='checked';
		return  $this->select('customers.*')->from('customers')
				->where($where)->result()[0];
	}

	public function update_userinfo($post,$token){
		$request = \Clips\context('request');
		$user = $this->user->load($post['id']);
		if(!$user){
			$uid = $this->addUser($post['id']);
		}
		$customer = $this->customer->one(array('uid'=>$post['uid']));
		if(!$customer){
			$this->customer->addCustomer($post,$uid);
		}
		$this->logger->debug('cast data is ',array($token));
		$this->curl->post("http://user.pinet.co/api/update_basic_info", array(
				'token' =>$token,
				'username' =>$post['username'],
//				'password' =>md5($post['password']),
//				'first_name' => $post['first_name'],
//				'last_name' => $post['last_name'],
				'sex' => $post['radio'],
				'birthday'=>$post['year'].'-'.$post['month'].'-'.$post['day'],
//				'mobile' => $post['mobile'],
//				'email' => $post['email']
		));
		if($this->curl->http_status_code == 200) {
			$response = json_decode($this->curl->response);
			$request->session('bestpay_username',$post['username']);
		}
		return $response->success;
	}

	public function get_userinfo($getToken){
		$request = \Clips\context('request');
		if($getToken) {
			$token = json_decode($this->encryptor->publicDecrypt($getToken));
			$users = $this->load($token->uid);
			if (isset($token->uid)) {
				if (isset($users->id)) {
					$request->session('user_id', $users->id);
					$this->curl->get("http://user.pinet.co/api/get_user_data", array('token' =>$getToken));
					if($this->curl->http_status_code == 200) {
						return $response = json_decode($this->curl->response);
					}
				}
			}
		}
	}

	public function update_account($token,$mobile){
		$this->curl->post("http://user.pinet.co/api/update_basic_info", array(
				'token' =>$token,
				'mobile' =>$mobile
		));
		if($this->curl->http_status_code == 200) {
			$response = json_decode($this->curl->response);
		}
		return $response->success;
	}
}
