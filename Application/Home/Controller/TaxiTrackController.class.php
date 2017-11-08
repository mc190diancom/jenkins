<?php
namespace Home\Controller;
use Think\Controller;
class TaxiTrackController extends BestController {
    public function TaxiTrack(){
    	$this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', time () ) );

        $this->assign("check",3);
        $this->display("TaxiTrack");
    }
    //获取执法车的轨迹
    function ajaxTaxiTrack(){
        $json_data['startTime'] = strtotime(I("startTime"))*1000;
        $json_data['endTime']   = strtotime(I("endTime"))*1000;
        /*if($json_data['starttime']>time()){
           $json_data['starttime'] = strtotime(date('Y-m-d 00:00:00',time()));
        }
        if($json_data['endtime']>time()){
            $json_data['endtime'] = time();
        }*/
        $json_data['vname']     = substr(I("vName"), 3);

        
        $json = json_encode($json_data);
        $url_before = C('URL_BEFORE');
        //requestApi?type=queryHistoryTrack&jsonStr={"vname":"B2Y083","startTime":1420080953300,"endTime":1420084553300}
        $url = $url_before.'/requestApi?type=queryHistoryTrack&jsonStr='.$json;
        
        $json_point = postHttp($url);
//echo $url;
        $R = json_decode($json_point,true);
        $Res = $R;
        //
        import("Org.Util.GPS");
        $gps = new \GPS();
        for ($i=0; $i < count($Res); $i++) { 
            $gps1[$i] = $gps->gcj_encrypt($Res[$i]['LAT84'],$Res[$i]['LON84']);
        }
        for ($j=0; $j < count($gps1); $j++) { 
            $gps2[$j] = $gps->bd_encrypt($gps1[$j]['lat'],$gps1[$j]['lon']);
        }

        //echo $json_point;
        $this->ajaxReturn($gps2); 
    }


}