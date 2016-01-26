$('[data-role="cart"]').hover(function(){
	$(this).find('.cartdown').stop().slideToggle();
});



$('.cart .info[nologin="true"]').on('click', function(e){
	e.preventDefault();
	$('#myModal').modal('show');
});

//$('input, textarea').placeholder();


$('[placeholder]').focus(function() {
	var input = $(this);
	if (input.val() == input.attr('placeholder')) {
		input.val('');
		input.removeClass('placeholder');
	}
}).blur(function() {
	var input = $(this);
	if (input.val() == '' || input.val() == input.attr('placeholder')) {
		input.addClass('placeholder');
		input.val(input.attr('placeholder'));
	}
}).blur();




$('[placeholder]').parents('form').submit(function() {
	$(this).find('[placeholder]').each(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
			input.val('');
		}
	})
});


