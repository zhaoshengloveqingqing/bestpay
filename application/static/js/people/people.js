
$(function(){
	$('.category').on('click', '.filter:not(.display) span', function(e){
		var self = $(e.currentTarget);
		self.parent().addClass('display');
		self.text("收起").addClass("style");
	});

	$('.category').on('click', '.filter.display span', function(e){
		var self = $(e.currentTarget);
		self.parent().removeClass('display');
		self.text("更多").removeClass('style');
	});
})
