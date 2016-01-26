<?php namespace Pinet\BestPay\Models; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Model to manipulate table tags
 *
 * @author Jake
 * @version 1.0
 * @date Sun Mar 15 12:08:08 2015
 *
 * @Clips\Model
 */
class TagModel extends DBModel {

	public function getTagByName($name){
		return $this->one(array('name'=> $name));
	}

	public function getChildrenTags($pid){
		return $this->get(array('parent_id'=> $pid));
	}

	public function getMaxLevel($module){
		$level = $this->select('max(tags.level) as level')->from('tags')->where(array(
				'tags.module' => $module
			))->result();
		if($level)
			return $level[0]->level;
		return 1;
	}

	public function getTagsByLevel($level, $module){
		$tags = $this->select('tags.id, tags.name')->from('tags')->where(array(
			'level'=> $level,
			'module'=> $module
		))->orderBy('tags.order')->result();
		array_unshift($tags, (object)array('id'=> '', 'name'=> 'All'));
		return $tags;
	}

	public function getTags($data){
		$level = $this->select('id,name,level as layer,path')->from('tags')->where(array(
				new \Clips\Libraries\LikeOperator("path", '/'.$data->id.'/' . "%")
		))->result();
		return $level;
	}

	public function getProductTagsByTagID($tag_id){
		return $this->one(array('id'=>$tag_id));
	}
}
