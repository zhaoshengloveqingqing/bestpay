var year =document.getElementById("my_year").value;
var month =document.getElementById("my_month").value;
var day = document.getElementById("my_day").value;

ymd = new YMDselect('year1','month1','day1', year, month, day);

function initialize() {
	//alert(document.getElementById("year1").value)
	var year1_select = $('[name=year1]').data('selectBox-selectBoxIt');
	var month1_select = $('[name=month1]').data('selectBox-selectBoxIt');
	var day1_select = $('[name=day1]').data('selectBox-selectBoxIt');

	$('[name=year1]').on('change', function(){
		YMDselect.SetM(ymd);
		month1_select.refresh();
		day1_select.refresh();
	});

	$('[name=month1]').on('change', function(){
		YMDselect.SetD(ymd);
		day1_select.refresh();
	});
}


$('#preserve').on('click', function(e){
	if(document.getElementById("radio1").checked){
		var radio = 'm';
	}
	if(document.getElementById("radio2").checked){
		var radio = 'f';
	}
	//alert(document.getElementById("sex").checked)
	//alert(document.getElementById("sex").checked)

	$.ajax({
		type: "POST",
		url: Clips.siteUrl('user/update_userinfo'),
		dataType: "json",
		data: {
			uid:$('#field_uid').val(),
			id: $('#field_id').val(),
			username: $('#field_username').val(),
			year: $('#year').val(),
			month: $('#month').val(),
			day: $('#day').val(),
			radio: radio
		},
		success : function(data){
			if(data.success){
				alert(data.msg);
				//document.location.reload();
			}else{
				alert(data.msg);
			}
		}
	});
})