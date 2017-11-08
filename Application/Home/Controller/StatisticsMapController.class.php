<?php
namespace Home\Controller;
use Think\Controller;

class StatisticsMapController extends BestController{
    /**
     * 执法队员检查地点分布热点图
     */
    function addressDistribution(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', time () ) );
        //$this->assign ( "endDate", "2016-08-22 00:00:00" );

        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",4);
        $this->display("addressDistribution");
    }
    function ajaxAddressDistribution(){
        $name = I('name');
        $dd = I('dd');
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间

        $c['name'] = $name;
        if($dd != '全部'){
            $c['dd'] = $dd;
        }else{
            $c['dd'] = '';
        }
        //$c['startTime'] = strtotime($startTime);
        //$c['endTime'] = strtotime($endTime);


        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=addressDistribution&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        //$Res = $R['loc'];
         $Res = $R['rows'];
         //p($R);

        import("Org.Util.GPS");
        $gps = new \GPS();
        /*ACCOUNT: "administrator"
        LAT: 30.58664
        LON: 104.056126
        PERSONNAME: "管理员"
        SSDD: null*/
        for ($i=0; $i < count($Res); $i++) { 
            $gps1[$i] = $gps->gcj_encrypt($Res[$i]['LAT'],$Res[$i]['LON']);
            $gps1[$i]['PERSONNAME'] = $Res[$i]['PERSONNAME'];
            $gps1[$i]['SSDD'] = $Res[$i]['SSDD'];
            $gps1[$i]['ACCOUNT'] = $Res[$i]['ACCOUNT'];
        }
        for ($j=0; $j < count($gps1); $j++) { 
            $gps2[$j] = $gps->bd_encrypt($gps1[$j]['lat'],$gps1[$j]['lon']);
            $gps2[$j]['personName'] = $gps1[$j]['PERSONNAME'];
            $gps2[$j]['ssdd'] = $gps1[$j]['SSDD'];
            $gps2[$j]['account'] = $gps1[$j]['ACCOUNT'];
        }
        
        $this->ajaxReturn($gps2); 
    }

    /********/
    /**
     * 执法车分布图
     */
    function taxiDistribution(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', time () )  );
        //$this->assign ( "endDate", "2016-08-22 00:00:00" );

        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",4);
        $this->display("taxiDistribution");
    }
    function ajaxtaxiDistribution(){
        $vName = I('vName');
        $dd = I('dd');
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间
 
        if($vName){
            $c['vName'] = $vName;
        }else{
            $c['vName'] = '';
        }
        if($dd != '全部'){
            $c['dd'] = $dd;
        }else{
            $c['dd'] = '';
        }
        $c['startTime'] = strtotime($startTime);
        $c['endTime'] = strtotime($endTime);


        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=taxiDistribution&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        //echo C("URL_BEFORE")."/requestApi/bs_Taxi?type=taxiDistribution&jsonStr=".$arr_json;
        //$Res = $R['loc'];
         $Res = $R['rows'];
        //p($R);
         /*["VNAME"]=>
      string(9) "京LE3625"
      ["LON"]=>
      int(11648802)
      ["LAT"]=>
      int(3985162)
      ["SPEED"]=>
      int(0)
      ["HEAD"]=>
      int(177)
      ["UTC"]=>
      int(1471579635)
      ["SGNAME"]=>
      string(9) "五大队"*/

        import("Org.Util.GPS");
        $gps = new \GPS();
        for ($i=0; $i < count($Res); $i++) { 
            $gps1[$i] = $gps->gcj_encrypt($Res[$i]['LAT']/100000,$Res[$i]['LON']/100000);
            $gps1[$i]['VNAME'] = $Res[$i]['VNAME'];
            $gps1[$i]['SPEED'] = $Res[$i]['SPEED'];
            $gps1[$i]['HEAD'] = $Res[$i]['HEAD'];
            $gps1[$i]['UTC'] = $Res[$i]['UTC'];
            $gps1[$i]['SGNAME'] = $Res[$i]['SGNAME'];
        }
        for ($j=0; $j < count($gps1); $j++) { 
            $gps2[$j] = $gps->bd_encrypt($gps1[$j]['lat'],$gps1[$j]['lon']);
            $gps2[$j]['VNAME'] = $gps1[$j]['VNAME'];
            if ($gps1[$j]['HEAD'] > 337.5){
                $gps2[$j]['HEAD'] = "北";
            }else if ($gps1[$j]['HEAD'] > 292.5){
                $gps2[$j]['HEAD'] = "西北";
            }else if ($gps1[$j]['HEAD'] > 247.5){
                $gps2[$j]['HEAD'] = "西";
            }else if ($gps1[$j]['HEAD'] > 202.5){
                $gps2[$j]['HEAD'] = "西南";
            }else if ($gps1[$j]['HEAD'] > 157.5){
                $gps2[$j]['HEAD'] = "南";
            }else if ($gps1[$j]['HEAD'] > 112.5){
                $gps2[$j]['HEAD'] = "东南";
            }else if ($gps1[$j]['HEAD'] > 67.5){
                $gps2[$j]['HEAD'] = "东";
            }else if ($gps1[$j]['HEAD'] > 22.5){
                $gps2[$j]['HEAD'] = "东北";
            }else{
                $gps2[$j]['HEAD'] = "北";
            }

            $gps2[$j]['SPEED'] = $gps1[$j]['SPEED']*0.036;
            //$gps2[$j]['HEAD'] = $gps1[$j]['HEAD'];
            $gps2[$j]['UTC'] = date('Y-m-d H:i:s',$gps1[$j]['UTC']);
            $gps2[$j]['SGNAME'] = $gps1[$j]['SGNAME'];
        }
        
        $this->ajaxReturn($gps2); 
    }


    /*********************/
    /**
     * 投诉案件分布情况热点图
     */
    function complaintCaseDistribution(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', time () ) );
        //$this->assign ( "endDate", "2016-08-22 00:00:00" );

        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",4);
        $this->display("complaintCaseDistribution");
    }
    function ajaxcomplaintCaseDistribution(){

    }

    /**
     * 违规行为地理分布热点图
     */
    function irregularitiesDistribution(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );
        //$this->assign ( "endDate", "2016-08-22 00:00:00" );

        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",4);
        $this->display("irregularitiesDistribution");
    }
    function ajaxirregularitiesDistribution(){
        
    }
    /*********************/
    /**
     * 执法时间段热点图(日)
     */
    function timeDistribution(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01" );
        //$this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );
        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",4);
        $this->display("timeDistribution");
    }
    function ajaxtimeDistribution(){
        //requestApi/bs_Taxi?type=timeDistribution&jsonStr={"dd":"北京市交通执法总队首都机场执法大队","startTime":"1469980800"}
        $dd = I('dd');
        $startTime = I('startTime');//起始时间

        $c['dd'] = $dd;
        $c['startTime'] = strtotime($startTime);
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=timeDistributionByDay&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $R1 = $R['rows'];
        //p($R);
        $arr['dd'] = $dd;
        $arr['time'] = date('Y年m月d日',strtotime($startTime));
        $arr['rows'][0]['name'] = '处罚数';
        $arr['rows'][1]['name'] = '未处罚数';
        for ($i=0; $i < count($R1); $i++) {
            $arr['rows'][0]['data'][$i] = $R1[$i]['STAT5'];
            $arr['rows'][1]['data'][$i] = $R1[$i]['COUNT']-$R1[$i]['STAT5'];
        }
        //p($arr);
        //die;
        /*$arr = array(
                'total'=>24,
                'title'=>'执法考核对比表',
                'rows'=>array(
                        array(
                            'name'=>'第一大队',
                            'data'=>array(5,3,2,1,7,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
                        ),
                        array(
                            'name'=>'第二大队',
                            'data'=>array(3,4,3,5,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
                        ),
                        array(
                            'name'=>'第三大队',
                            'data'=>array(2,5,1,5,8,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
                        ),
                    ),

            );*/

        $this->ajaxReturn ($arr);
    }

    /**
     * 执法时间段热点图(月)
     */
    function MtimeDistribution(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01" );
        //$this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );
        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",4);
        $this->display("MtimeDistribution");
    }
    function ajaxMtimeDistribution(){
        $dd = I('dd');
        $startTime = I('startTime');//起始时间

        $c['dd'] = $dd;
        $c['startTime'] = strtotime($startTime);
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=timeDistribution&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $R1 = $R['rows'];
        //p($R);
        $arr['dd'] = $dd;
        $arr['time'] = date('Y年m月',strtotime($startTime));
        $arr['rows'][0]['name'] = '处罚数';
        $arr['rows'][1]['name'] = '未处罚数';
        for ($i=0; $i < count($R1); $i++) {
            $arr['rows'][0]['data'][$i] = $R1[$i]['STAT5'];
            $arr['rows'][1]['data'][$i] = $R1[$i]['COUNT']-$R1[$i]['STAT5'];
        }
        //p($arr);
        //die;
        /*$arr = array(
                'total'=>24,
                'title'=>'执法考核对比表',
                'rows'=>array(
                        array(
                            'name'=>'第一大队',
                            'data'=>array(5,3,2,1,7,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
                        ),
                        array(
                            'name'=>'第二大队',
                            'data'=>array(3,4,3,5,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
                        ),
                        array(
                            'name'=>'第三大队',
                            'data'=>array(2,5,1,5,8,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
                        ),
                    ),

            );*/

        $this->ajaxReturn ($arr);
    }
}