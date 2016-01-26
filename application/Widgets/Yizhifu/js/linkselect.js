(function($){
	var url = window.location.hostname + window.location.pathname;

	function renderSelect(sel, data) {
		var str = '';
		var template = '<option value="{{value}}">{{name}}</option>';
		var options = [];

		if(!$.isEmptyObject(data)) {
			for (var i in data) {
				if($.isNumeric(i)) {
					options.push(data[i]);
				}
			}
		}

		for (var i = 0; i < options.length; i++) {
			if($.isPlainObject(options[i])) {

			}
			var tem = template.replace('{{name}}', options[i].name);
			str += tem.replace('{{value}}', options[i].id);
		}

		$(sel).append(str);

		redraw(sel);
	}

	function renderCaption(sel) {
		var str = '';
		var template = '<option control="optionhead">{{name}}</option>';
		str = template.replace('{{name}}', '~');

		$(sel).find('option').remove();

		$(sel).append(str);
	}

	function prependCaption(sel) {
		var str = '';
		var template = '<option control="optionhead">{{name}}</option>';
		str = template.replace('{{name}}', '~');

		$(sel).prepend(str);
	}

	function appendCaption(sel) {
		var str = '';
		var template = '<option control="optionhead">{{name}}</option>';
		str = template.replace('{{name}}', '~');

		$(sel).append(str);
	}

	function selectCaption(sel) {
		$(sel).find('[control=optionhead]').prop('selected', true);
	}

	function removeCaption(sel) {
		$(sel).find('[control=optionhead]').remove();
	}

	function selectOption(sel) {
		$(sel).find('option:not([control=optionhead]):eq(0)').prop('selected', true);
		$(sel).trigger('change');
	}

	function selectOptionWithIndex(sel, index) {
		$(sel).find('option:not([control=optionhead])[value='+index+']').prop('selected', true);
		$(sel).trigger('change');
	}

	$.linkselect = {};
	$.linkselect.selectOptionWithIndex = selectOptionWithIndex;

	function redraw(sel) {
		var selectbox = $(sel).data('selectBox-selectBoxIt');
		selectbox.refresh();
	}

	$.fn.casecadeSelect = function(watching, options) {
		var self = $(this);

		var defaults = {
			form: 'select',
			template: '<option>{{name}}</option>',
			onChange: function(){}
		};

		var op = $.extend({}, defaults, options);

		op.form = self.parentsUntil('form').parent().attr('name');

		if(self.find('option').length == 0) {
			renderCaption(self);
			renderCaption(watching);
		}

		self.on('change', function(){
			var value = self.val();
			var field = $(watching).parent().parent().attr('field');
			var form = op.form;
			if(self.find('option:selected').attr('control') != 'optionhead') {
				renderCaption(watching);
				$.post(url, {
					form: form,
					field: field,
					cascade_value: value
				}, function(data){
					renderSelect(watching, data);
					if($.isFunction(op.onChange)) {
						op.onChange(data);
					}
				}, 'json');
			}
			else {
				if($.isFunction(op.onSelectCaption)) {
					op.onSelectCaption(self);
				}
			}
		});
	};

	function initliazeSelect(sel) {
		var self = $(sel);
		if(self.find('option[selected]').length < 1) {
			prependCaption(self);
			selectCaption(self);
		}
	}


	function linkSelect(selectone, selecttwo, selectthree) {
		if (typeof selectthree == 'undefined') {
			initliazeSelect(selectone);

			$(selectone).casecadeSelect(selecttwo, {
				onChange: function(data){
					if(!$.isEmptyObject(data)) {
						$(selecttwo).trigger('selecthasdata');
					}
					else {
						redraw(selecttwo);
					}
				},
				onSelectCaption: function(self) {
					renderCaption(selecttwo);
					redraw(selecttwo);
				}
			});
		}
		else {
			initliazeSelect(selectone);

			$(selectone).casecadeSelect(selecttwo, {
				onChange: function(data){
					if(!$.isEmptyObject(data)) {
						renderCaption(selectthree);
						$(selecttwo).trigger('selecthasdata');
					}
					else {
						// selectOption(selecttwo);
						redraw(selecttwo);
					}
					renderCaption(selectthree);
					redraw(selectthree);
				},
				onSelectCaption: function(self) {
					renderCaption(selecttwo);
					redraw(selecttwo);
					renderCaption(selectthree);
					redraw(selectthree);
				}
			});
			$(selecttwo).casecadeSelect(selectthree, {
				onChange: function(data){
					if(data.length < 1) {
						// renderCaption(selectthree);
					}
					else {
						// removeCaption(selectthree);
						redraw(selectthree);
						$(selectthree).trigger('selecthasdata');
					}
				},
				onSelectCaption: function(self) {
					renderCaption(selectthree);
					redraw(selectthree);
				}
			});
		}
	}

	window.linkSelect = linkSelect;
})(jQuery);