

$(function(){

	//$(".nav-title li").on("click", function(){
	//	$(this).children('a').addClass("up");
	//});
	$('.category').on('click', '.filter:not(.display) span', function(e){
		var self = $(e.currentTarget);
		self.parent().addClass('display');
		self.text("收起");
	});

	$('.category').on('click', '.filter.display span', function(e){
		var self = $(e.currentTarget);
		self.parent().removeClass('display');
		self.text("More");
	});

	$("#mall_index").on('list.loaded', function(e, list){
		var items = list.find('li:not(.listview_item_template)');
		if(items.length > 0) {
			items.each(function(i){
				var self = $(this);
				if(i%4 == 0) {
					self.addClass('first');
				}
				else if(i%4 == 3) {
					self.addClass('last');
				}
			});
		}

		var malllistview = $('#mall_index').data('api');

		$('#amount').on('click', 'a:not(.up)', function(e) {
			var self = $(e.currentTarget);
			self.parent().parent().find('li').removeClass('active');
			self.parent().addClass('active');
			self.addClass('up');
			malllistview.sort(10, 'ASC');
		});

		$('#amount').on('click', 'a.up', function(e) {
			var self = $(e.currentTarget);
			self.parent().parent().find('li').removeClass('active');
			self.parent().addClass('active');
			self.removeClass('up');
			malllistview.sort(10, 'DESC');
		});
		$('#price').on('click', 'a:not(.up)', function(e) {
			var self = $(e.currentTarget);
			self.parent().parent().find('li').removeClass('active');
			self.parent().addClass('active');
			self.addClass('up');
			malllistview.sort(6, 'ASC');
		});

		$('#price').on('click', 'a.up', function(e) {
			var self = $(e.currentTarget);
			self.parent().parent().find('li').removeClass('active');
			self.parent().addClass('active');
			self.removeClass('up');
			malllistview.sort(6, 'DESC');
		});
		$('#time').on('click', 'a:not(.up)', function(e) {
			var self = $(e.currentTarget);
			self.parent().parent().find('li').removeClass('active');
			self.parent().addClass('active');
			self.addClass('up');
			malllistview.sort(9, 'ASC');
		});

		$('#time').on('click', 'a.up', function(e) {
			var self = $(e.currentTarget);
			self.parent().parent().find('li').removeClass('active');
			self.parent().addClass('active');
			self.removeClass('up');
			malllistview.sort(9, 'DESC');
		});

	});


})