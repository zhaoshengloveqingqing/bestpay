function getCookie(name)
{
	alert(1111)
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
		return unescape(arr[2]);
	else
		return null;
}

function SetCookie(sName, sValue){
	date = new Date();
	date.setDate(date.getDate()+30);
	document.cookie = escape (sName)+'='+escape(sValue)+'; expires='+date.toGMTString();
}
$('#search').on('click', function(e) {
	var search=document.getElementById('search_input').value;
	SetCookie("search",search)
})
document.getElementById('search_input').value=getCookie('search');