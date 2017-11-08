<?php 
namespace Home\Controller;
use Think\Controller;
/**
 * 公共控制器
 */
class CommonController extends BestController{
	//出租车 行业列表
	function get_jclb(){
		$url   = C("URL_BEFORE")."/requestApi/other?type=get_jclb";   
	    $Rjson =  postHttp($url);
	    $R2 = json_decode($Rjson,true);
	    return $R2;
	}

}