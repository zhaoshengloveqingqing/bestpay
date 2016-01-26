<?php namespace Pinet\BestPay\Widgets\Yizhifu; in_array(__FILE__, get_included_files()) or exit("No direct sript access allowed");

class Widget extends \Clips\Widget {
	protected function doInit() {
		$js = 
<<<TEXT

	//====================================
	// Initializing YiZhiFu
	//====================================
	function drawItem(context, list) {
		var listviewApi = context.data('api');
		if($.isFunction($.fn.picture)) {
			$('.listview.clips-listview').find('figure,picture').picture({
				pictureReady: function(mediapath){
					listviewApi.layout(list);
				}
			});
		}
	}
	$('.listview.clips-listview').on('list.loaded', function(e, list, opt){
		var self = $(this);
//		drawItem(self, list);
	});
	$('.listview.clips-listview').on('list.resize', function(e, list){
		var self = $(this);
//		drawItem(self, list);
	});
	$('.listview.clips-listview').on('list.init', function(){
		var listviewApi = $(this).data('api');
		listviewApi.clear();
	});
	function checkTargetInElement(e) {
		var self = $(e.target);
		var isInside = false;
		var element = $(e.data.ele);
		element.each(function(i, ele){
			if($.contains(element[0], e.target)) {
				isInside = true;
				return false;
			}
		});
		if(!isInside) {
			element.trigger('check.out');
		}else {
			element.trigger('check.in');
		}
	}
	$(document).on('click', {ele: '.listview.clips-listview'} ,checkTargetInElement);
	$('.listview.clips-listview').on('check.out', function(e){});
	$('.listview.clips-listview').on('check.in', function(e){
		var self = $(this);
		self.on('click', '.ui-selectee.listview_item', function(e){
			$(this).addClass('ui-selected').siblings().removeClass('ui-selected');
		});
	});
TEXT;
		\Clips\context('jquery_init', $js, true);
	}
}
