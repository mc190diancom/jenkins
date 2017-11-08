<?php
define('PI',3.1415926535898);

define('EARTH_RADIUS',6378137);

function p($str){
    echo "<pre>";
    var_dump($str);
     echo "</pre>";
}

  function changeStartTime($starTime){
      $dateC = strtotime($starTime);
      $starTime = date("Ymdhi",$dateC);
      return $starTime;
    }
    //转化结束时间
    function changeTime($endTime){
        $dateO = strtotime($endTime);
        $endTime = date("Ymd",$dateO);
        return $endTime;
    }
    //curl
   function postHttp($api, array $params = array(), $timeout = 30) {
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $api );
        // 以返回的形式接收信息
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        // 设置为POST方式
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $params ) );
        // 不验证https证书
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
            'Accept: application/json'
        ) );
        // 发送数据
        $response = curl_exec ( $ch );
        // 不要忘记释放资源
        curl_close ( $ch );
        return $response;
    }
    //判断是哪个接口
   function url($hylb){
        if($hylb == "旅游车")
        {
            $url = C("URL_LVYOU") ;
        }
        if($hylb == "客运及客运站经营")
        {
            $url = C("URL_SHENGJI") ;
        }
        if($hylb == "货运及货运站经营")
        {
            $url = C("URL_HUOYUN") ;
        }
        if($hylb == "")
        {
            $url = C("URL_ZULIN") ;
        }
        return $url;
    }
    //获取所有单位名称（大队的）
 function getCompName(){
        $url_b = C("URL_BEFORE");
        //$url = $url_b."/requestApi/zhifache?type=getCorpList";
        $url = $url_b.'/requestApi/zfry?type=getGroup_Name&jsonStr={"ZFDWMC":""}';
       
        $comName = postHttp($url);
        $comNames = json_decode($comName,true);
        /*foreach ($comNames as $key => $value) {
            if($value['ZFDWMC'] == '北京市交通执法总队第一执法大队'){
                $newComNames[0]['ZFDWMC'] = $value['ZFDWMC'];
            }elseif(){
                $newComNames[1]['ZFDWMC'] = $value['ZFDWMC'];
            }
        }*/
        return $comNames;

    }

//中队 车组
/*function getGroups($zfdwmc,$sszd=''){
    $url_b = C("URL_BEFORE");
    //$url = $url_b."/requestApi/zhifache?type=getCorpList";
    $url = $url_b.'/requestApi/zfry?type=getGroups&jsonStr={"zfdwmc":"'.$zfdwmc.'","sszd":"'.$sszd.'"}';
   
    $Groups = postHttp($url);
    $Groups = json_decode($Groups,true);
    return $Groups;
}*/


/**
* 简单对称加密算法之加密
*/
function encode($string = '', $skey = 'chenchuan') {
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value)
        $key < $strCount && $strArr[$key].=$value;
    return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
}
/**
* 简单对称加密算法之解密
*/
function decode($string = '', $skey = 'chenchuan') {
    $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value)
        $key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    return base64_decode(join('', $strArr));
}

//添加制表符
function addT($addT){
     $ChangeT = "\t".$addT;
     return $ChangeT;
}

function mymArrsort($arr,$var){
    $tmp=array();
    $rst=array();
    foreach($arr as $key=>$trim){
        $tmp[$key]=$trim[$var];
    }
    arsort($tmp);
    $i=0;
    foreach($tmp as $key1=>$trim1){
        $rst[$i]=$arr[$key1];
        $i=$i+1;
    }
    return $rst;
}

// 弧度转换
function rad($d) {
    return $d * 3.1415926535898 / 180.0;
}

function GetDistance($lat1, $lng1, $lat2, $lng2){

  $radLat1 = $lat1 * (PI / 180);

  $radLat2 = $lat2 * (PI / 180);

  $a = $radLat1 - $radLat2;

  $b = ($lng1 * (PI / 180)) - ($lng2 * (PI / 180));

  $s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));

  $s = $s * EARTH_RADIUS;

  $s = round($s * 10000) / 10000;

  return $s;

}


?>