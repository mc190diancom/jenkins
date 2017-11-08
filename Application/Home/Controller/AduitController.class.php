<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/18
 * Time: 13:11
 */

namespace Home\Controller;


use Home\Model\LoginModel;

class AduitController extends BestController
{
    //车辆轨迹定位查询
     public function aduit(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60*5 ) ));
        $this->assign("check",3);
        $this->display('');
     }
    //ajax获取轨迹点
    function ajaxGetLinePoint(){
        $json_data['startTime'] = strtotime(I("startTime"))*1000;
        $json_data['endTime']   = strtotime(I("endTime"))*1000;
        $json_data['vname']     = strtoupper(I("carNum"));//京B13184
        $vname = I("carNum");
        $json = json_encode($json_data);
     
        $url_before = C('URL_BEFORE');
        $url = $url_before."/requestApi?type=queryHistoryTrackForRoad&jsonStr=".$json;
        /*$filename = '11667.log';
        $Ts=fopen($filename,"a+");
        fputs($Ts,"\r\n".json_encode ($url));
        fclose($Ts);*/
        $json_point = postHttp($url);
        $R1 = json_decode($json_point,true);
   
        $R = $R1['loc'];
        /*for ($o=1; $o < count($R['loc']); $o++) { 
            if(abs($R['loc'][$o]['AZIMUTHS']-$R['loc'][$o-1]['AZIMUTHS'])>= 30){
                    $Rs[$o] = $R['loc'][$o];
                } 
        }*/

        for ($o=1; $o < count($R); $o++) { 
           $RR[] = GetDistance($R[$o]['LAT84'],$R[$o]['LON84'],$R[$o-1]['LAT84'],$R[$o-1]['LON84']);
        }

        $tmpv = 0;
        foreach($RR as $key=>$v){
            //p($v);
            if($tmpv+$v >800){
               $arr_new[] = $key;
               $tmpv = 0;
            }else{
                $tmpv +=$v;
            }
        }
       
       array_unshift($arr_new,1);
       array_push($arr_new,count($RR));
       /*p($R);
       die;*/
       for ($b=0; $b < count($R); $b++) { 
           if(in_array($b,$arr_new)){
                $Rs[$b] = $R[$b];
           }
       }
        /*p($arr_new);
        die;*/
        //$Rs1 = $R[count($R)-1];
        $Res = array_reverse(array_reverse($Rs));

        /*p($Res);
        die;*/
        $json2 = postHttp(C('URL_BEFORE')."/requestApi/common?type=queryCurrentPostion&vname=".$vname."&flag=1");
        $R2 = json_decode($json2,true);
        //echo C('URL_BEFORE')."/requestApi/common?type=queryCurrentPostion&vname=".$vname."&flag=1";
//p($R2);
        //$Res = $R['loc'];
        import("Org.Util.GPS");
        $gps = new \GPS();
        for ($i=0; $i < count($Res); $i++) { 
            $gps1[$i] = $gps->gcj_encrypt($Res[$i]['LAT84'],$Res[$i]['LON84']);
            //$gps1[$i]['VEHICLE_STATUS'] = $Res[$i]['VEHICLE_STATUS'];
            $gps1[$i]['AZIMUTHS'] = $Res[$i]['AZIMUTHS'];
            $gps1[$i]['GPS_TIME'] = $Res[$i]['GPS_TIME'];
        }
        for ($j=0; $j < count($gps1); $j++) { 
            $gps2[$j] = $gps->bd_encrypt($gps1[$j]['lat'],$gps1[$j]['lon']);
            
            $gps2[$j]['AZIMUTHS'] = $gps1[$j]['AZIMUTHS'];
            
            //$gps2[$j]['VEHICLE_STATUS'] = $gps1[$j]['VEHICLE_STATUS'];
            $gps2[$j]['GPS_TIME'] = $gps1[$j]['GPS_TIME'];
        }
       // echo $json_point;
       
       $count = count($gps1);

       if($count>=2){
            $lastj = $count-1;
            $c1['coord_type'] = "bd09ll";
            $c1['destination'] = "终点|".$gps2[0]['lat'].",".$gps2[0]['lon'];
            $c1['destination_region'] = "北京";
            $c1['mode'] = "driving";
            $c1['origin'] = "起点|".$gps2[$lastj]['lat'].",".$gps2[$lastj]['lon'];
            $c1['origin_region'] = "北京";
            $c1['region'] = "北京";
            $c1['tactics'] = "12";
            $json_c1 = json_encode($c1);
            //type=queryRoutePlan&jsonStr={"coord_type":"bd09ll","destination":"终点|39.735897,116.172192","destination_region":"北京","mode":"driving","origin":"起点|39.996725,116.497405","origin_region":"北京","region":"北京","tactics":"12"}
            $json_info_c1 = postHttp(C('URL_BEFORE').'/requestApi?type=queryRoutePlan&jsonStr='.$json_c1);
            /*echo C('URL_BEFORE').'/requestApi?type=queryRoutePlan&jsonStr='.$json_c1;
            die;*/
            $Rc1 = json_decode($json_info_c1,true);
        }

        $Res1 = $Rc1['result']['routes'][0]['steps'];
        foreach ($Res1 as $k1 => $v1) {
            if($v1['direction']!=-1){
                $rot = 0;
                switch ($v1['direction']) {
                case 0:
                    $rot = 0;
                    break;
                case 1:
                    $rot = 30;
                    break;
                case 2:
                    $rot = 60;
                    break;
                case 3:
                    $rot = 90;
                    break;
                case 4:
                    $rot = 120;
                    break;
                case 5:
                    $rot = 150;
                    break;
                case 6:
                    $rot = 180;
                    break;
                case 7:
                    $rot = 210;
                    break;
                case 8:
                    $rot = 240;
                    break;
                case 9:
                    $rot = 270;
                    break;
                case 10:
                    $rot = 300;
                    break;
                case 11:
                    $rot = 330;
                    break;
                default:
                    break;
                }
            }
            $arr[] = explode(';',$v1['path'].','.$rot);
            
        }

        $Result['gps1'] = call_User_Func_Array('array_Merge',$arr);
        /*p($Result['gps1']);
        die;*/
        /*p($Result['gps1']);
        die;*/
        $Result['gps'] = $gps2;
        /*p($R2);
        die;*/
        $Result['info'] = $R2;
        //echo $json_point;
        $this->ajaxReturn($Result);
        

        /*$res['loc'] = $gps2;
        $res['info']['model'] = $R2['model'];
        $res['info']['color'] = $R2['color'];
        $res['info']['compName'] = $R2['corpName'];
        $res['info']['err'] = $R2['err'];
        $res['info']['PLATE_NO'] = $R2['vname'];
        $this->ajaxReturn($res);*/ 
    }

    function road_position(){
        $this->assign("check",3);
        $this->display('road_position');
    }
    //道路运输实时定位
    function ajaxGetCurrentPoint(){
        $vname     = strtoupper(I("vname"));//京B13185
        //echo $url = C('URL_BEFORE')."/requestApi/common?type=queryCurrentPostion&vname=".$vname."&flag=1";
        $json_point = postHttp(C('URL_BEFORE')."/requestApi/common?type=queryCurrentPostion&vname=".$vname."&flag=1");
        $R = json_decode($json_point,true);
        //p($R);
        $this->ajaxReturn($R);
    }

    function demo(){
        /*$json_data['startTime'] = strtotime('2016-08-02 14:00:00')*1000;
        $json_data['endTime']   = strtotime('2016-08-02 21:00:00')*1000;
        $json_data['vname']     = '京B10829';*/

        $json_data['starttime'] = strtotime('2016-08-02 00:00:00');
        $json_data['endtime']   = strtotime('2016-08-02 14:00:00');
        $json_data['vname']     = '京LH9961';
        $json = json_encode($json_data);
     
        $url_before = C('URL_BEFORE');
        
        $url = $url_before."/requestApi/zhifache?type=getHistoryLineByVname&jsonStr=".$json;
        //$url = $url_before."/requestApi?type=queryHistoryTrackForRoad&jsonStr=".$json;
       /* $filename = '11667.log';
        $Ts=fopen($filename,"a+");
        fputs($Ts,"\r\n".json_encode ($url));
        fclose($Ts);*/
        $json_point = postHttp($url);
        $R = json_decode($json_point,true);
        //$Res = $R['loc'];
         $Res = $R;
         //p($R);
        //
        import("Org.Util.GPS");
        $gps = new \GPS();
        for ($i=0; $i < count($Res); $i++) { 
            $gps1[$i] = $gps->gcj_encrypt($Res[$i]['LAT'],$Res[$i]['LON']);
        }
        for ($j=0; $j < count($gps1); $j++) { 
            $gps2[$j] = $gps->bd_encrypt($gps1[$j]['lat'],$gps1[$j]['lon']);
        }
        /*for ($i=0; $i < count($Res); $i++) { 
            $gps1[$i] = $gps->gcj_encrypt($Res[$i]['LAT84'],$Res[$i]['LON84']);
        }
        for ($j=0; $j < count($gps1); $j++) { 
            $gps2[$j] = $gps->bd_encrypt($gps1[$j]['lat'],$gps1[$j]['lon']);
        }*/
       // p($gps1);
        p($gps2);
    }
}