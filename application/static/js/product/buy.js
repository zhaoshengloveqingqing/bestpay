$(".add").click(function(){
	var t=$(this).parent().find('input[class*=text_box]');
    t.val(parseInt(t.val())+1);
    setTotal();
});
$(".min").click(function(){
    var t=$(this).parent().find('input[class*=text_box]');
    t.val(parseInt(t.val())-1);
    if(parseInt(t.val())<1){
        t.val(1);
    }
    setTotal();
});

$( "#number" ).data('oldamount', 1);

$( "#number" ).on('keyup', function (e) {
	var self=$(this);
	var amount=self.val();

	if(amount == '0') {
		self.data('oldamount', amount);
		self.val(1);
	}

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



var map = new BMap.Map('allmap');
// 用经纬度设置地图中心点
function theLocation($longitude,$latitude){
	if($longitude != "" && $latitude != ""){
		map.clearOverlays();
		var new_point = new BMap.Point($longitude, $latitude);
		var marker = new BMap.Marker(new_point);  // 创建标注
		marker.enableDragging(); //marker可拖拽
		marker.addEventListener("click", function(e){
			searchInfoWindow1.open(marker);
		})
		map.addOverlay(marker);              // 将标注添加到地图中
		map.panTo(new_point);
	}
}

if(document.getElementById("allmap").getAttribute("longitude")!=null){
	var poi = new BMap.Point(document.getElementById("allmap").getAttribute("longitude"), document.getElementById("allmap").getAttribute("latitude"));
}
var poi = new BMap.Point(document.getElementById("allmap").getAttribute("longitude"), document.getElementById("allmap").getAttribute("latitude"));
map.centerAndZoom(poi, 16);
map.enableScrollWheelZoom();

var content = '<div style="margin:0;line-height:20px;padding:2px;">' +
		'<img src="application/static/img/banner_mall_1.jpg" alt="" style="float:right;zoom:1;overflow:hidden;width:100px;height:100px;margin-left:3px;"/>' +
		'地址：苏州工业园区星湖街328号创意产业园15栋506<br/>电话：(0512)65920626<br/>简介：苏州派尔科技有限公司是一家创新型网络商业解决方案的科技公司。' +
		'</div>';

//创建检索信息窗口对象
var searchInfoWindow = null;
searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
	title  : "创意产业园",      //标题
	width  : 230,             //宽度
	height : 85,              //高度
	panel  : "panel",         //检索结果面板
	enableAutoPan : true,     //自动平移
	searchTypes   :[
		BMAPLIB_TAB_SEARCH,   //周边检索
		BMAPLIB_TAB_TO_HERE,  //到这里去
		BMAPLIB_TAB_FROM_HERE //从这里出发
	]
});
var marker = new BMap.Marker(poi); //创建marker对象
marker.enableDragging(); //marker可拖拽
marker.addEventListener("click", function(e){
	searchInfoWindow.open(marker);
})
map.addOverlay(marker); //在地图中添加marker
//样式1

var content1 = '<div style="margin:0;line-height:20px;padding:2px;">' +
		'<img src="application/static/img/banner_mall_1.jpg" alt="" style="float:right;zoom:1;overflow:hidden;width:100px;height:100px;margin-left:3px;"/>' +
		'地址：安徽省合肥市紫蓬山风景区森林大道三号安徽文达信息工程学院<br/>电话：(0551)68582777<br/>简介：安徽文达信息工程学院坐落于合肥市国家4A级风景区紫蓬山下，堰湾湖畔，是一所由安徽文达集团举办、国家教育部批准的全日制普通本科高校。世界诺贝尔物理学奖获得者杨振宁教授曾两次亲临学校指导工作，并亲笔题写校名。' +
		'</div>';
var searchInfoWindow1 = new BMapLib.SearchInfoWindow(map, content1, {
	title  : "安徽文达信息工程学院",      //标题
	width  : 230,             //宽度
	height : 85,              //高度
	panel  : "panel",         //检索结果面板
	enableAutoPan : true,     //自动平移
	searchTypes   :[
		BMAPLIB_TAB_SEARCH,   //周边检索
		BMAPLIB_TAB_TO_HERE,  //到这里去
		BMAPLIB_TAB_FROM_HERE //从这里出发
	]
});
function openInfoWindow1() {
	searchInfoWindow1.open(new BMap.Point(116.319852,40.057031));
}
//样式2
var searchInfoWindow2 = new BMapLib.SearchInfoWindow(map, "信息框2内容", {
	title: "信息框2", //标题
	panel : "panel", //检索结果面板
	enableAutoPan : true, //自动平移
	searchTypes :[
		BMAPLIB_TAB_SEARCH   //周边检索
	]
});
function openInfoWindow2() {
	searchInfoWindow2.open(new BMap.Point(116.324852,40.057031));
}
//样式3
var searchInfoWindow3 = new BMapLib.SearchInfoWindow(map, "信息框3内容", {
	title: "信息框3", //标题
	width: 290, //宽度
	height: 40, //高度
	panel : "panel", //检索结果面板
	enableAutoPan : true, //自动平移
	searchTypes :[
	]
});
function openInfoWindow3() {
	searchInfoWindow3.open(new BMap.Point(116.328852,40.057031));
}

