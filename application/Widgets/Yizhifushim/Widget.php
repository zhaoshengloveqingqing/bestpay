<?php namespace Pinet\BestPay\Widgets\Yizhifushim; in_array(__FILE__, get_included_files()) or exit("No direct sript access allowed");

class Widget extends \Clips\Widget {
	protected function doInit() {
		$js = 
<<<TEXT
	var calcTime = function(options){
		var defaults = {
			second: 1000,
			minute: 60,
			hour: 60,
			day: 24,
			week: 7,
			mode: 'day',
			dayNum: 0
		};
		var opt = $.extend( { }, defaults, options);

		if(mode = 'day') {
			return opt.second * opt.minute * opt.hour * opt.day * opt.dayNum;
		}
	}

	var dayUnixTime = calcTime({
		dayNum: 1
	});

	var weekUnixTime = calcTime({
		dayNum: 7
	});

	var monthUnixTime = calcTime({
		dayNum: 30
	});

	var now = moment();
	var dayBeforeNow = moment(now.valueOf() - dayUnixTime);
	var weekBeforeNow = moment(now.valueOf() - weekUnixTime);
	var monthBeforeNow = moment(now.valueOf() - monthUnixTime);

	$("[data-date-time*=yesterday]").on("click", function(e){
		e.preventDefault();
		$("[data-date-control*=front]").data("DateTimePicker").date(dayBeforeNow);
		$("[data-date-control*=end]").data("DateTimePicker").date(dayBeforeNow);
		return false;
	});

	$("[data-date-time*=oneWeekBeforeNow]").on("click", function(e){
		e.preventDefault();
		$("[data-date-control*=front]").data("DateTimePicker").date(weekBeforeNow);
		$("[data-date-control*=end]").data("DateTimePicker").date(now);
		return false;
	});

	$("[data-date-time*=oneMonthBeforeNow]").on("click", function(e){
		e.preventDefault();
		$("[data-date-control*=front]").data("DateTimePicker").date(monthBeforeNow);
		$("[data-date-control*=end]").data("DateTimePicker").date(now);
		return false;
	});

	$("[data-date-time*=clearAll]").on("click", function(e){
		e.preventDefault();
		$("[data-date-control*=front]").val('');
		$("[data-date-control*=end]").val('');
		return false;
	});

	$("[data-date-time*=clearFront]").on("click", function(e){
		e.preventDefault();
		$("[data-date-control*=front]").val('');
		return false;
	});

	$("[data-date-time*=clearEnd]").on("click", function(e){
		e.preventDefault();
		$("[data-date-control*=end]").val('');
		return false;
	});
TEXT;
		\Clips\context('jquery_init', $js, true);
	}
}
