<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/18
 * Time: 14:11
 */

namespace Home\Controller;


use Home\Model\LoginModel;

class ChartController extends BestController
{
    //统计图检查地点分布
    public function sta_img(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60 ) )); 
        $compName =  getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",4);
        $this->display("sta_img");
    }
    //执法车热点分布图
    public function enforce_img(){
         
        $compName =  getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",5);
        $this->display("enforce_img");
    }
    //ajax获取enforce的车辆位置
    public function ajaxGetEnforcePoint(){
        $sgname['corpName'] = I("compName");
        $jsonStr = json_encode($sgname);
        $b_url = C("URL_BEFORE");
        $url = $b_url."/requestApi/zhifache?type=getVehiclePositionByCorpID&jsonStr=".$jsonStr;
         
        $json_data =  postHttp($url);
        echo $json_data;
    }

    //ajax获取sta人员的位置
    function ajaxGetStaPoint(){
        $R['totalNum'] = 0;
        $R['startIndex'] = 0;
        $R['endIndex'] = 0;
        $R['account'] = null;
        $R['lon'] = null;
        $R['lat'] = null;
        if(I("compName")=="全部"){
            $R['personName'] = "";
        }else{
            $R['personName'] = null;
        }
        
        $R['ssdd'] = I("compName");
        $jsonStr = json_encode($R);
        $b_url = C("URL_BEFORE");
        $url = $b_url."/requestApi/person_fb?type=queryPersonPosition&jsonStr=".$jsonStr;
         
        $json_data =  postHttp($url);
        /*$R = json_decode($json_data,true);
        //$Res = $R['loc'];
         $Res = $R;
         //p($R);

        import("Org.Util.GPS");
        $gps = new \GPS();
        for ($i=0; $i < count($Res); $i++) { 
            $gps1[$i] = $gps->gcj_encrypt($Res[$i]['lat'],$Res[$i]['lon']);
            $gps1[$i]['personName'] = $Res[$i]['personName'];
            $gps1[$i]['ssdd'] = $Res[$i]['ssdd'];
            $gps1[$i]['account'] = $Res[$i]['account'];
            $gps1[$i]['totalNum'] = $Res[$i]['totalNum'];
        }
        for ($j=0; $j < count($gps1); $j++) { 
            $gps2[$j] = $gps->bd_encrypt($gps1[$j]['lat'],$gps1[$j]['lon']);
            $gps2[$j]['personName'] = $gps1[$j]['personName'];
            $gps2[$j]['ssdd'] = $gps1[$j]['ssdd'];
            $gps2[$j]['account'] = $gps1[$j]['account'];
            $gps2[$j]['totalNum'] = $gps1[$j]['totalNum'];
        }*/
        echo $json_data;
        //$this->ajaxReturn($gps2); 
    }
    public function zhexian_img(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) );
        $compName =  getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",4);
        $this->display("zhexian_img");
    }
    function ajaxGetZXPoint(){
         $startTime = I("startDate");
        //$R["zfdwmc"]  = I("compName");
        $c["hylb"]      =   I("hylb");
        $c["startTime"] = strtotime(I("startDate"));
        //$R["endTime"]   = "";
        //$R['times']     = 12;
        $jsonStr = json_encode($c);
        //queryCountByTime&jsonStr={"hylb":"旅游客运","startTime":1474732800}
        //{"hylb":"出租车","startTime":1464230113,"endTime":"","zfdwmc":"","times":12}
        //$url = $b_url.'/requestApi/xinxi?type=queryCountByTime&jsonStr={"hylb":"出租车","startTime":1464230113,"endTime":"","zfdwmc":"","times":12}';
        $json_data =  postHttp(C("URL_BEFORE")."/requestApi/xinxi?type=queryCountByTime&jsonStr=".$jsonStr);
      //echo C("URL_BEFORE")."/requestApi/xinxi?type=queryCountByTime&jsonStr=".$jsonStr;
        $R = json_decode($json_data,true);
        //p($R);
        $R1 = $R['rows'];
        $arr['time'] = date('Y年m月d日',strtotime($startTime));
        for ($i=0; $i < count($R1); $i++) {
            $arr['rows'][$i]['name'] = $R1[$i]['name'];
            for ($j=0; $j < count($R1[$i]['data']); $j++) { 
                $arr['rows'][$i]['data'][$j] = $R1[$i]['data'][$j]['COUNT'];//
            }
        }
        
        
        $R = $arr;
        $this->ajaxReturn ($R);
    }

    public function aduit_img(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60 ) )); 
        $compName =  getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",4);
        $this->display("aduit_img");
    }
    function ajaxAduitPoint(){
        $R["hylb"] = I("hylb");
        /*$R["startTime"]  =1464230113;// strtotime(I("startTime"));
        $R["endTime"]    = 1464700000;//strtotime(I("endTime"));
        $R["zfdwmc"]  = I("compName");
        $R["lon_A"]   =  116.301215; //I("f1");
        $R["lat_A"]   = 39.993916;//I("f2");
        $R["lon_B"]   = 116.484901;//I("s1");
        $R["lat_B"]   = 39.841403;//I("s2");*/
        $R["startTime"]  =strtotime(I("startTime"));
        $R["endTime"]    = strtotime(I("endTime"));
        $R["zfdwmc"]  = I("compName");
        $R["lon_A"]   =  I("f1");
        $R["lat_A"]   = I("f2");
        $R["lon_B"]   = I("s1");
        $R["lat_B"]   =I("s2");
        $jsonStr = json_encode($R);
         
        $b_url = C("URL_BEFORE");
        $url  = $b_url."/requestApi/xinxi?type=queryCountByPlace&jsonStr=".$jsonStr;
       /* $filename = '11237.log';
        $Ts=fopen($filename,"a+");
        fputs($Ts,"\r\n".json_encode ($url));
        fclose($Ts);
        $json =  postHttp($url);*/
        //echo $json;
        $json =  postHttp($url);
        $R = json_decode($json,true);
        $Res[0] = $R[0];
        $this->ajaxReturn($Res);
        /*$Res[0] = $R[1];
         //$Res = $R;
        //p($Res);
        import("Org.Util.GPS");
        $gps = new \GPS();
        for ($i=0; $i < count($Res); $i++) { 
            $gps1[$i] = $gps->gcj_encrypt($Res[$i]['lat'],$Res[$i]['lon']);
            $gps1[$i]['address'] = $Res[$i]['address'];
            $gps1[$i]['zfdwmc'] = $Res[$i]['zfdwmc'];
        }
        for ($j=0; $j < count($gps1); $j++) { 
            $gps2[$j] = $gps->bd_encrypt($gps1[$j]['lat'],$gps1[$j]['lon']);
            $gps2[$j]['address'] = $gps1[$j]['address'];
            $gps2[$j]['zfdwmc'] = $gps1[$j]['zfdwmc'];
        }
         $this->ajaxReturn($gps2);*/
    }

    //月
    public function zhexian_img_m(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60 ) ));  
        $compName =  getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",4);
        $this->display("zhexian_img_m");
    }
    function ajaxGetZXPointM(){
         $startTime = I("startDate");
        //$R["zfdwmc"]  = I("compName");
        $c["hylb"]      =   I("hylb");
        $c["startTime"] = strtotime(I("startDate"));
        
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/xinxi?type=getCount_Month&jsonStr=".$arr_json);
        //echo C("URL_BEFORE")."/requestApi/xinxi?type=getCount_Month&jsonStr=".$arr_json;
        $R = json_decode($R_json,true);
        $R1 = $R['rows'];
        //p($R);
        $arr['time'] = date('Y年m月',strtotime($startTime));
        for ($i=0; $i < count($R1); $i++) {
            $arr['rows'][$i]['name'] = $R1[$i]['name'];
            for ($j=0; $j < count($R1[$i]['data']); $j++) { 
                $arr['rows'][$i]['data'][$j] = $R1[$i]['data'][$j]['COUNT'];
            }
        }
/*p($arr);
die;*/
        $R = $arr;
        $this->ajaxReturn ($R);
    }


    function demo(){
        $R['totalNum'] = 0;
        $R['startIndex'] = 0;
        $R['endIndex'] = 0;
        $R['account'] = null;
        $R['lon'] = null;
        $R['lat'] = null;
        $R['personName'] = null;
        $R['ssdd'] = "北京市交通执法总队第五执法大队";
        $jsonStr = json_encode($R);
        $b_url = C("URL_BEFORE");
        $url = $b_url."/requestApi/person_fb?type=queryPersonPosition&jsonStr=".$jsonStr;
         
        $json_data =  postHttp($url);
        $R = json_decode($json_data,true);
        //$Res = $R['loc'];
         $Res = $R;
         //p($R);
        //
        import("Org.Util.GPS");
        $gps = new \GPS();
        for ($i=0; $i < count($Res); $i++) { 
            $gps1[$i] = $gps->gcj_encrypt($Res[$i]['lat'],$Res[$i]['lon']);
            $gps1[$i]['personName'] = $Res[$i]['personName'];
            $gps1[$i]['ssdd'] = $Res[$i]['ssdd'];
            $gps1[$i]['account'] = $Res[$i]['account'];
            $gps1[$i]['totalNum'] = $Res[$i]['totalNum'];
        }
        for ($j=0; $j < count($gps1); $j++) { 
            $gps2[$j] = $gps->bd_encrypt($gps1[$j]['lat'],$gps1[$j]['lon']);
            $gps2[$j]['personName'] = $gps1[$j]['personName'];
            $gps2[$j]['ssdd'] = $gps1[$j]['ssdd'];
            $gps2[$j]['account'] = $gps1[$j]['account'];
            $gps2[$j]['totalNum'] = $gps1[$j]['totalNum'];
        }
         //p($gps1);
        p($gps2);
    }


    function demo1(){
        $R["hylb"] = '';
        $R["startTime"]  =1464230113;// strtotime(I("startTime"));
        $R["endTime"]    = 1464700000;//strtotime(I("endTime"));
        $R["zfdwmc"]  = '北京市交通执法总队第五执法大队';
        $R["lon_A"]   =  116.301215; //I("f1");
        $R["lat_A"]   = 39.993916;//I("f2");
        $R["lon_B"]   = 116.484901;//I("s1");
        $R["lat_B"]   = 39.841403;//I("s2");
        $jsonStr = json_encode($R);
         
        $b_url = C("URL_BEFORE");
        $url  = $b_url."/requestApi/xinxi?type=queryCountByPlace&jsonStr=".$jsonStr;
        $json =  postHttp($url);
        $R = json_decode($json,true);
        //p($R);
        $Res[0] = $R[1];
         //$Res = $R;
        //p($Res);
        import("Org.Util.GPS");
        $gps = new \GPS();
        for ($i=0; $i < count($Res); $i++) { 
            $gps1[$i] = $gps->gcj_encrypt($Res[$i]['lat'],$Res[$i]['lon']);
            $gps1[$i]['address'] = $Res[$i]['address'];
            $gps1[$i]['zfdwmc'] = $Res[$i]['zfdwmc'];
        }
        for ($j=0; $j < count($gps1); $j++) { 
            $gps2[$j] = $gps->bd_encrypt($gps1[$j]['lat'],$gps1[$j]['lon']);
            $gps2[$j]['address'] = $gps1[$j]['address'];
            $gps2[$j]['zfdwmc'] = $gps1[$j]['zfdwmc'];
        }
         //p($gps1);
        p($gps2);
    }

    function demo2(){
        $R["zfdwmc"]  = I("compName");
        $R["hylb"]      =   I("hylb");
        $R["startTime"] = strtotime(I("startDate"));
        $R["endTime"]   = "";
        $R['times']     = 12;
        $b_url     = C("URL_BEFORE");
        $jsonStr = json_encode($R);
        //{"hylb":"出租车","startTime":1464230113,"endTime":"","zfdwmc":"","times":12}
        //$url = $b_url."/requestApi/xinxi?type=queryCountByTime&jsonStr=".$jsonStr;
        $url = $b_url.'/requestApi/xinxi?type=queryCountByTime&jsonStr={"hylb":"出租车","startTime":1464230113,"endTime":"","zfdwmc":"","times":12}';
        $json_data =  postHttp($url);
       /* $filename = '111.log';
        $Ts=fopen($filename,"a+");
        fputs($Ts,"\r\n".json_encode ($url));
        fclose($Ts);*/
        $arr = json_decode($json_data,true);
        $arr_son = array(0=>array('COUNT'=>0,'ZFDWMC'=>'八大队'),
                           1=> array('COUNT'=>0,'ZFDWMC'=>'二大队'),
            2=> array('COUNT'=>0,'ZFDWMC'=>'轨道大队'),
            3=> array('COUNT'=>0,'ZFDWMC'=>'机场大队'),
            4=> array('COUNT'=>0,'ZFDWMC'=>'六大队'),
            5=> array('COUNT'=>0,'ZFDWMC'=>'七大队'),
            6=> array('COUNT'=>0,'ZFDWMC'=>'三大队'),
            7=> array('COUNT'=>0,'ZFDWMC'=>'四大队'),
            8=> array('COUNT'=>0,'ZFDWMC'=>'五大队'),
            9=> array('COUNT'=>0,'ZFDWMC'=>'一大队'),
            10=> array('COUNT'=>0,'ZFDWMC'=>'直属大队'),


                            );
        foreach($arr as $k=>$v)
        {
            if($v[0]==0)
            {
                 $arr[$k] = $arr_son;
            }
        }
        p( $arr);
    }

    function demo3(){
        $R["zfdwmc"]  = '北京市交通执法总队第五执法大队';
        //$R["hylb"]      =   I("hylb");
        $R["startTime"] = '1469411366';
        //$R["endTime"]   = "";
        //$R['times']     = 12;
        $b_url     = C("URL_BEFORE");
        $jsonStr = json_encode($R);
        //http://localhost:8080/requestApi/xinxi?type=getCount_Month&jsonStr={"startTime":1469411366,"zfdwmc":"北京市交通执法总队第五执法大队"}
        $url = $b_url."/requestApi/xinxi?type=getCount_Month&jsonStr=".$jsonStr;
        $json_data =  postHttp($url);
       /* $filename = '111.log';
        $Ts=fopen($filename,"a+");
        fputs($Ts,"\r\n".json_encode ($url));
        fclose($Ts);*/
        $arr = json_decode($json_data,true);
        $arr_son = array(0=>array('COUNT'=>0,'ZFDWMC'=>'八大队'),
                           1=> array('COUNT'=>0,'ZFDWMC'=>'二大队'),
            2=> array('COUNT'=>0,'ZFDWMC'=>'轨道大队'),
            3=> array('COUNT'=>0,'ZFDWMC'=>'机场大队'),
            4=> array('COUNT'=>0,'ZFDWMC'=>'六大队'),
            5=> array('COUNT'=>0,'ZFDWMC'=>'七大队'),
            6=> array('COUNT'=>0,'ZFDWMC'=>'三大队'),
            7=> array('COUNT'=>0,'ZFDWMC'=>'四大队'),
            8=> array('COUNT'=>0,'ZFDWMC'=>'五大队'),
            9=> array('COUNT'=>0,'ZFDWMC'=>'一大队'),
            10=> array('COUNT'=>0,'ZFDWMC'=>'直属大队'),


                            );

        //p($arr);
        /*foreach ($arr_son as $key => $value) {
            foreach ($arr as $k => $v) {
                if($arr[$k][0]['COUNT']){
                    $arr_son[$key][$k]['COUNT'] = $arr[$k][0]['COUNT'];
                    $arr_son[$key][$k]['ZFDWMC'] = $arr[$k][0]['ZFDWMC'];
                }else{
                     $arr_son[$key][$k]['COUNT'] = '0';
                }
               
            }
        }*/
        foreach($arr as $k=>$v)
        {
            if($v[0]==0)
            {
                 $arr[$k] = $arr_son;
            }
        }
        p($arr);
    }
}