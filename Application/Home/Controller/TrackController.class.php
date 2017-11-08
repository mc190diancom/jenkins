<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/18
 * Time: 11:47
 */

namespace Home\Controller;


use Home\Model\LoginModel;

class TrackController extends BestController
{
    //稽查定位查询
    public function track(){
        $this->assign("check",8);
        $b_url = C("URL_BEFORE") ;
        $url = $b_url."/requestApi/zhifache?type=queryCompany_vname_count";
      
        $json_data = postHttp($url);
        $json_data1 = json_decode($json_data,true);
        //p($json_data1);
        /*$arr = $json_data1;
        $arr1 = array_splice($json_data1,0,11);
        //p($json_data1);
        $arr2 = array_splice($arr, 12,1);
        $arr3 = array_merge($arr1,$arr2);
        p($arr3);*/
        $compName = getCompName();
        $this->assign("compName",$compName);
        $this->assign('R',$json_data1);
        $this->display('track');
    }
    function ajaxGetPoinot(){
        $vname['vname'] = I("vname");
        $jsonVname = json_encode($vname);
        if($vname!='')
        {
            $b_url = C("URL_BEFORE") ;
            $url = $b_url.'/requestApi/zhifache?type=getVehiclePositionByVname&jsonStr='.$jsonVname;
            
            $json_data = postHttp($url);
            $json_data1 = json_decode($json_data,true);
            $this->ajaxReturn($json_data1);
        }
       else{
           echo 1;
       }

    }
    public function track_aduit(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60*5 )));
        $this->assign("check",8);
        $b_url = C("URL_BEFORE") ;
        $url = $b_url."/requestApi/zhifache?type=queryCompany_vname_count";

        $json_data = postHttp($url);
        $json_data1 = json_decode($json_data,true);
        /*$arr = $json_data1;
        $arr1 = array_splice($json_data1,0,1);
        //p($json_data1);
        $arr2 = array_splice($arr, 2);
        $arr3 = array_merge($arr1,$arr2);*/
        //p($arr3);
        $compName = getCompName();
        $this->assign("compName",$compName);
        $this->assign('R',$json_data1);
        $this->display('track_aduit');
    }
    //获取执法车的轨迹
    function ajaxGetLinePoint(){
        $json_data['starttime'] = strtotime(I("startTime"));
        $json_data['endtime']   = strtotime(I("endTime"));
        /*if($json_data['starttime']>time()){
           $json_data['starttime'] = strtotime(date('Y-m-d 00:00:00',time()));
        }
        if($json_data['endtime']>time()){
            $json_data['endtime'] = time();
        }*/
        $json_data['vname']     = I("carNum");
        $json = json_encode($json_data);
        $url_before = C('URL_BEFORE');
        $url = $url_before.'/requestApi/zhifache?type=getHistoryLineByVname&jsonStr='.$json;
        //$url ='http://123.57.236.212:8080/requestApi?type=queryHistoryTrackForRoad&jsonStr={%22vname%22:%22%E4%BA%ACB10829%22,%22startTime%22:1465660800000,%22endTime%22:1465748939000}';
        $json_point = postHttp($url);

        $R = json_decode($json_point,true);
        $Res = $R;
        //
        import("Org.Util.GPS");
        $gps = new \GPS();
        for ($i=0; $i < count($Res); $i++) { 
            $gps1[$i] = $gps->gcj_encrypt($Res[$i]['LAT'],$Res[$i]['LON']);
        }
        for ($j=0; $j < count($gps1); $j++) { 
            $gps2[$j] = $gps->bd_encrypt($gps1[$j]['lat'],$gps1[$j]['lon']);
        }

        //echo $json_point;
        $this->ajaxReturn($gps2); 
    }


    function demo(){
        $vname['vname'] = '京JF0601';
        $jsonVname = json_encode($vname);
        if($vname!='')
        {
            $b_url = C("URL_BEFORE") ;
           echo $url = $b_url.'/requestApi/zhifache?type=getVehiclePositionByVname&jsonStr='.$jsonVname;
            die;
            $json_data = postHttp($url);
            $json_data1 = json_decode($json_data,true);
            p($json_data1);
        }
       else{
           echo 1;
       }
    }

}