<?php namespace Pinet\BestPay; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

function user_is_logged_in() {
	$tool = &\Clips\get_clips_tool();
	$user = $tool->model('user');
	\Clips\log('The id of user is {0}', array($user->getCurrentUserId()));
	return !!$user->getCurrentUserId();
}

function merchant_is_logged_in() {
	$tool = &\Clips\get_clips_tool();
	$merchant = $tool->model('merchant');
	\Clips\log('The id of user is {0}', array($merchant->getCurrentMerchantID()));
	return !!$merchant->getCurrentMerchantID();
}