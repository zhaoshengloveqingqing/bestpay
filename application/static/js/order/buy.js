$(".add").click(function(){
    var t=$(this).parent().find('input[class*=text_box]');
    t.val(parseInt(t.val())+1)
    setTotal();
})
$(".min").click(function(){
    var t=$(this).parent().find('input[class*=text_box]');
    t.val(parseInt(t.val())-1)
    if(parseInt(t.val())<1){
        t.val(1);
    }
    setTotal();
})

$( "#number" ).data('oldamount', 1);

$( "#number" ).on('keyup', function (e) {
	var self=$(this);
	var amount=self.val();

	if(amount == '' ||  $.isNumeric(amount)) {
		self.data('oldamount', amount);
	}
	else {
		self.val(self.data('oldamount'));
	}
});

$( "#number" ).on('blur', function(){
	var self=$(this);
	var amount=self.val();

	if(amount == '' || String(amount).indexOf(".")>-1) {
		self.val(1);
	}
});

function setTotal(){
    var price=parseFloat($("#price").text());
    var amount=parseInt($("#number").val());
    var total= 0;
    total+=parseFloat(price*amount);
    $("#total_Price").html(total);
    $("#totalPrice").html(total);
}
setTotal();
