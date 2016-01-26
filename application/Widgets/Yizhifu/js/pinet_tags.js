+function($) {
	if(typeof Clips === 'undefiend')
		Clips = {};

	Clips.DataSource = function(data) {
		if(data) {
			this.data = data;
		}
	}

	Clips.AjaxDataSource = function() {
	}

	Clips.AjaxDataSource.prototype = {
		loadChildren: function(path, level, callback) {
			$.post("#", {level: level, path: path}, callback, "json");
		},
		loadLayer: function(level, callback) {
			$.post("#", {level: level}, callback, "json");
		}
	};

	Clips.DataSource.prototype = {
		loadChildren: function(path, level, callback) {
			if(this.data && $.isNumeric(level) && level >= 0) {
				var result = [];
				$(this.data).each(function(i, item) {
					if(item.layer == level && item.path.indexOf(path) === 0) {
						result.push(item);
					}
				});
				callback(result);
			}
		},
		loadLayer: function(level, callback) {
			if(this.data && $.isNumeric(level) && level >= 0) {
				var result = [];
				$(this.data).each(function(i, item) {
					if(item.layer == level) {
						result.push(item);
					}
				});
				callback(result);
			}
		}
	}

	Clips.Layer = function(datasource, node) {
		this.ds = datasource;
		this.node = node;
		$(this.node).data('layer', this);
		this.init();
	}

	Clips.Layer.prototype = {
		level: function() {
			return $(this.node).data('level');
		},
		parentLevel: function() {
			var level = this.level();
			if($.isNumeric(level)) {
				return level - 1;
			}
		},
		init: function() {
			if(this.ds) {
				var self = this;
				this.ds.loadLayer(this.level(), function(items){
					self.showItems(items);
				});
			}
		},
		clearItems: function(callback) {
			var self = this;
			$("li", self.node).remove().promise().done(callback);
			$(self.node).trigger('list.tags.refresh', [self]);
		},
		showItems: function(items) {
			var template = $('script[type="text/x-handlebars-template"]', this.node);
			var self = this;
			if(template.length > 0) {
				template = template.html().trim();

				var path = '/';
				if(self.path)
					path = self.path;

				//$(self.node).append(self.createItem(template, {name: 'All', path: path}));

				var callback = function(data) {
					return function(item){
						$(self.node).append(self.createItem(template, item));
					}(data);
				};

				if(items) {
					if(items.length > 0) {
						$(window).load(function(){
							$(self.node).trigger('list.tags.init-active', [self]);
						});
					}
					$.each(items, function(i){
						callback(items[i]);
					});
				}
			}
		},
		getParentLayer: function() {
			var level = $(this.node).data('level');
			var layer = $('ul[data-level="' + --level + '"]');
			if(layer.length) {
				return layer.data('layer');
			}
			return null;
		},
		getNextLayer: function() {
			var level = $(this.node).data('level');
			var layer = $('ul[data-level="' + ++level + '"]');
			if(layer.length) {
				return layer.data('layer');
			}
			return null;
		},
		createItem: function(template, data) {
			var item = $(S(template).template(data, '_(', ')').toString());
			var self = this;
			item.click(function() {
				$(this).addClass('active').siblings().removeClass('active');
				var next = self;
				while(true) {
					next = next.getNextLayer();
					var i = 0;
					if(next) {
						next.path = $(this).data('id');
						next.clearItems(function(){
						});
						var callback = function(data) {
							return function(items) {
								data.showItems(items);
								++i;
								if(items.length > 0) {
									$(self.node).trigger('list.tags.always-active', [data]);
								}
							}
						}(next);
						self.ds.loadChildren($(this).data('id'), next.level(), callback);
					}
					else {
						break;
					}
				}
			});
			return item;
		}
	}
}(jQuery);
