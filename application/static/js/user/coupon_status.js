$('#search-btn').on('click', function(e){
    $.ajax({
        type: "POST",
        url: Clips.siteUrl('admin/user/search_code'),
        dataType: "json",
        data: { coupon_code: $('#field_coupon_code').val()},
        success : function(data){
            if(data.success){
                $('#field_coupon_code').val('');
                alert(data.msg);
            }else{
                alert(data.msg);
            }
        }
    });
})