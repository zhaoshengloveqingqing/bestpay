<?php namespace Pinet\BestPay\Core; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");


class Pages {

	//分页
	//Tcount 总数
	//Tpage  每页显示数量
	//p 当$p=3时，打开http://trunk.com/houtai/life/shop则跳转到第3页
	static function multi($Tcount, $Tpage, $p, $url='', $url1='') {

		$mu = "";
		//总页数
		$z = ceil($Tcount / $Tpage);
		$l = 10;    //长度
		$v = $l/2;

		$diy = ($p>1 && $p<$z)?($p-1):0;
		$mu.="<a href='".$url."1".$url1."' class='curved'>首页</a>";
		$mu .= "\r\n";
		if($p-1>=1){
			//$mu .= "<a href=\"".$url.$url1."\" title=\"上一页\" class=\"pre\">上一页</a>\r\n";
		}
		if($p>$v) $mu .= "\r\n";
		//开始
		$ca = (($p - $v)<0) ? 0 : ($p - $v);
		//结束
		$cb = (($p + $v)>$z) ? $z : ($p + $v);

		if($cb-$ca<($l+1)){
			$x = ($l+1)-($cb-$ca);
			if($ca==0 && $cb<$z){
				if(($z-$cb)<$x){
					$cb = $cb + ($z-$cb);
				}else{
					$cb = $cb + $x;
				}
			}elseif($cb==$z && $ca>0){
				if(($ca-$x)<0){
					$ca = 0;
				}else{
					$ca = $ca - $x;
				}
			}
		}
		for($i=$ca;$i<$cb;$i++){
			//$pi = ($p==($i+1))?"class=\"current\"": "";
			if($p==($i+1)){
				$mu .= "<a class=\"active curved\">".intval($i+1)."</a>\r\n";
			}else{
				if($i==0){
					$mu .= "<a href=\"".$url.$url1."\" title=\"第".intval($i+1)."页\" class=\"curved\">[".intval($i+1)."]</a>\r\n";
				}else{
					$mu .= "<a href=\"".$url.($i+1).$url1."\" title=\"第".intval($i+1)."页\" class=\"curved\">[".intval($i+1)."]</a>\r\n";
				}
			}
		}

		if(($p+$v)<$z) $mu .= "\r\n";
		$end = ($p<$z)?$p+1:$z;
		if($p+1<=$z){
			//$mu .= "<a href=\"".$url.($p+1).$url1."\" title=\"下一页\" class=\"pre\">下一页</a>\r\n";
			$mu .= "\r\n";
		}
		$mu.="<a href='".$url.$z.$url1."' class=\"curved\">末页</a>";
		//$mu .= "\r\n";
		$mu.="   共{$Tcount}条记录/{$z}页";
		//$mu .= "\r\n";
		//$mu.="每页显示{$Tpage}条";
		return $mu;
	}

}