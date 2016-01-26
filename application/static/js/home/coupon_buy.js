$('#buy-btn').on('click', function(e){
    $.ajax({
        type: "POST",
        url: Clips.siteUrl('home/test'),
        dataType: "json",
        data: { coupon_code: $('#field_number').val()},
        success : function(data){
            if(data.success){
                $('#field_amount').val('');
                alert(data.msg);
            }else{
                alert(data.msg);
            }
        }
    });
})