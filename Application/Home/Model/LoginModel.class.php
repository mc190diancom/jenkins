<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/19
 * Time: 10:28
 */
namespace Home\Model;

use Think\Model;

class LoginModel extends Model
{
    //转化开始时间
    public function changeStartTime($starTime){
      $dateC = strtotime($starTime);
      $starTime = date("Ymdhi",$dateC);
      return $starTime;
    }
    //转化结束时间
    public function changeTime($endTime){
        $dateO = strtotime($endTime);
        $endTime = date("Ymd",$dateO);
        return $endTime;
    }
    //curl
    public function postHttp($api, array $params = array(), $timeout = 30) {
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
    public function url($hylb){
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
    public function getCompName(){
        $url_b = C("URL_BEFORE");
        $url = $url_b."/requestApi/zhifache?type=getCorpList";
        $comName = $this->postHttp($url);
        $comNames = json_decode($comName,true);
        return $comNames;

    }

}