<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table customers
 *
 * @author Jack
 * @version 1.0
 * @date Sun Mar 15 12:08:08 2015
 *
 * @Clips\Model({"user","customer"});
 * @Clips\Library({"encryptor", "curl"})
 */
class CustomerModel extends DBModel {
	public function addCustomer($gets,$uid){
		$now = new \DateTime();
		$data['uid'] = $uid;
		$data['delivery_address'] = $gets['delivery_address'];
		$data['create_date'] = $now->format('Y-m-d H:i:s');
		return $this->insert($data);
	}

	public function getCustomer($uid){
		if(!$uid){
			return array();
		}
		return $this->one(array(
				'uid' => $uid
		));
	}

	public function add_Address($post){
		$request = \Clips\context('request');
		$user_infos = $this->user->get_userinfo($request->session('token'));

		$user = $this->user->load($user_infos->id);
		if(!$user){
			$uid = $this->user->addUser($user_infos->id);
		}
		$customer = $this->customer->one(array('uid'=>$user_infos->uid));
		if(!$customer){
			$this->customer->addCustomer($post,$user_infos->uid);
		}
		$this->logger->debug('cast data is ',array($request->session('token')));
		$this->curl->post("http://user.pinet.co/api/update_basic_info", array(
				'token' =>$request->session('token'),
//				'username' =>$post['username'],
//				'password' =>md5($post['password']),
//				'first_name' => $post['first_name'],
//				'last_name' => $post['last_name'],
//				'sex' => $post['radio'],
//				'birthday'=>$post['year'].'-'.$post['month'].'-'.$post['day'],
				'mobile' => $post['mobile'],
//				'email' => $post['email']
		));
		if($this->curl->http_status_code == 200) {
			$response = json_decode($this->curl->response);
		}
		$now = new \DateTime();
		$uid = $this->user->getCurrentUserId();
		$customers = $this->get(array(
				'uid' => $uid,
				'default_address'=>'checked'
		));

		if($customers){
			for($i=0;$i<count($customers);$i++){
				$this->update((object)array(
						'id' =>$customers[$i]->id,
						'uid' => $uid,
						'default_address' =>"",
						'timestamp' =>$now->format('Y-m-d H:i:s')
				));
			}
		}
		$now = new \DateTime();
		$data['uid'] =$uid;
		$data['province'] =$post['province'];
		$data['city'] =$post['city'];
		$data['area'] =$post['area'];
		$data['delivery_address'] = $post['delivery_address'];
		$data['consignee']=$post['consignee'];
		$data['mobile']=$post['mobile'];
		if($post['checkbox']!=null){
			$data['default_address'] = 'checked';
		}
		if($post['default_address']!=null){
			$data['default_address'] = 'checked';
		}
		$data['create_date'] = $now->format('Y-m-d H:i:s');
		return $this->insert($data);
	}

	public function edit_Address($post){
		$request = \Clips\context('request');
		$user_infos = $this->user->get_userinfo($request->session('token'));

		$user = $this->user->load($user_infos->id);
		if(!$user){
			$uid = $this->user->addUser($user_infos->id);
		}
		$customer = $this->customer->one(array('uid'=>$user_infos->uid));
		if(!$customer){
			$this->customer->addCustomer($post,$user_infos->uid);
		}
		$this->logger->debug('cast data is ',array($request->session('token')));
		$this->curl->post("http://user.pinet.co/api/update_basic_info", array(
				'token' =>$request->session('token'),
//				'username' =>$post['username'],
//				'password' =>md5($post['password']),
//				'first_name' => $post['first_name'],
//				'last_name' => $post['last_name'],
//				'sex' => $post['radio'],
//				'birthday'=>$post['year'].'-'.$post['month'].'-'.$post['day'],
				'mobile' => $post['mobile'],
//				'email' => $post['email']
		));
		if($this->curl->http_status_code == 200) {
			$response = json_decode($this->curl->response);
		}
		$now = new \DateTime();
		$uid = $this->user->getCurrentUserId();
		$customers = $this->get(array(
				'uid' => $uid,
		));
		if($customers){
			for($i=0;$i<count($customers);$i++){
				$this->update((object)array(
						'id' =>$customers[$i]->id,
						'uid' => $uid,
						'default_address' =>"",
						'timestamp' =>$now->format('Y-m-d H:i:s')
				));
			}
		}
		$now = new \DateTime();
		if(isset($uid)){
			if($post['checkbox']!=null ||$post['default_address']!=null){
				$data['default_address'] = 'checked';
			}
			else{
				$data['default_address'] = '';
			}
//			if($post['default_address']!=null){
//				$data['default_address'] = 'checked';
//			}else{
//				$data['default_address'] = '';
//			}
			return $this->update((object)array(
					'id' =>$post['id'],
					'uid' =>$uid,
					'province' =>$post['province'],
					'city' =>$post['city'],
					'area' =>$post['area'],
					'delivery_address'=>$post['delivery_address'],
					'consignee'=>$post['consignee'],
					'mobile'=>$post['mobile'],
					'default_address' =>$data['default_address'],
					'timestamp' =>$now->format('Y-m-d H:i:s')
			));
		}
		return false;
	}

	public function getCustomerAddress($uid,$cid){
		return $this->get(array(
				'uid' => $uid,
				'id'=>$cid
		));
	}

	public function radio_check($id){
		$now = new \DateTime();
		if(isset($id)){
			return $this->update((object)array(
					'id' =>$id,
					'radio' =>"checked",
					'timestamp' =>$now->format('Y-m-d H:i:s')
			));
		}
		return false;
	}
	public function address_delete($id){
		$now = new \DateTime();
		if(isset($id)){
			$this->update((object)array(
					'id' =>$id,
					'status' =>"delete",
					'timestamp' =>$now->format('Y-m-d H:i:s')
			));
			return 1;
		}
		return false;
	}
	public function address_default($id){
		$now = new \DateTime();
		$uid = $this->user->getCurrentUserId();
		$customers = $this->get(array(
				'uid' => $uid,
		));

		if($customers){
			for($i=0;$i<count($customers);$i++){
				$this->update((object)array(
						'id' =>$customers[$i]->id,
						'uid' => $uid,
						'default_address' =>"",
						'timestamp' =>$now->format('Y-m-d H:i:s')
				));
			}
		}
		if(isset($id)){
			return $this->update((object)array(
					'id' =>$id,
					'default_address' =>"checked",
					'timestamp' =>$now->format('Y-m-d H:i:s')
			));
		}
		return false;
	}

	public function getAccountInfo($uid){
		if(!$uid){
			return array();
		}
		return $this->one(array(
				'uid' => $uid,
				'default_address'=>'checked'
		));
	}
	public function update_account($post){
		$request = \Clips\context('request');
		$this->curl->post("http://user.pinet.co/api/update_basic_info", array(
				'token' =>$request->session('token'),
				'email' => $post['email'],
		));
		if($this->curl->http_status_code == 200) {
			$response = json_decode($this->curl->response);
		}
		return true;
	}

}
