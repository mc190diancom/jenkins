<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 可疑车辆库
 */
class SuspiciousVehicleController extends BestController {
	/**
	 * 出库管理
	 */
    function Omanagement(){
    	$this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
		//$this->assign ( "startDate", "2016-08-01 00:00:00" );
		$this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );
		$common = A('Common');
		$HY_taxi = $common->get_jclb();
		//p($HY_taxi);
		$this->assign("HY_taxi",$HY_taxi);
		//大队
		$compName =  getCompName();
		$this->assign("compName",$compName);
        $this->assign("check",5);
        $this->display("Omanagement");
    }
    function ajaxOmanagement(){
        $vName = I('vName');
        $name = I('name');
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间
        if($vName != ''){
            $c['vName'] = $vName;
        }else{
            $c['vName'] = '';
        }
        if($name != ''){
            $c['name'] = $name;
        }else{
            $c['name'] = '';
        }

        $c['startTime'] = $startTime;
        $c['endTime'] = $endTime;

        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;
        
        $arr_json = json_encode($c);
        $arr_json = str_replace(' ','%20',$arr_json);
        //123.57.236.212:8080/requestApi/bs_Taxi?type=Omanagement&jsonStr={"vName":"","name":"","startTime":"2016-07-16 00:00:00","endTime":"2016-08-24 23:59:59"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=Omanagement&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }

    /**
     * 入库管理
     */
    function Imanagement(){
    	$this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
		//$this->assign ( "startDate", "2016-08-01 00:00:00" );
		$this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );
		$common = A('Common');
		$HY_taxi = $common->get_jclb();
		//p($HY_taxi);
		$this->assign("HY_taxi",$HY_taxi);
		//大队
		$compName =  getCompName();
		$this->assign("compName",$compName);
        $this->assign("check",5);
        $this->display("Imanagement");
    }
    function ajaxImanagement(){

        ///requestApi/bs_Taxi?type=Imanagement&jsonStr=
        //{"vName":"京BM8250","name":"吴斌","startTime":"2016-07-16 08:00:00","endTime":"2016-07-16 09:25:07"}
        $vName = I('vName');
        $name = I('name');
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间
        if($vName != ''){
            $c['vName'] = $vName;
        }else{
            $c['vName'] = '';
        }
        if($name != ''){
            $c['name'] = $name;
        }else{
            $c['name'] = '';
        }

        $c['startTime'] = $startTime;
        $c['endTime'] = $endTime;

        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;
        
        $arr_json = json_encode($c);
        $arr_json = str_replace(' ','%20',$arr_json);
        //123.57.236.212:8080/requestApi/bs_Taxi?type=Imanagement&jsonStr={"vName":"","name":"","startTime":"2016-07-16 00:00:00","endTime":"2016-08-24 23:59:59"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=Imanagement&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);

    }

    /**
     * 可疑车辆库管理
     */
    function SuspiciousVehicle(){
    	$this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
		//$this->assign ( "startDate", "2016-08-01 00:00:00" );
		$this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );
		$common = A('Common');
		$HY_taxi = $common->get_jclb();
		//p($HY_taxi);
		$this->assign("HY_taxi",$HY_taxi);
		//大队
		$compName =  getCompName();
		$this->assign("compName",$compName);
        $this->assign("check",5);
        $this->display("SuspiciousVehicle");
    }
    function ajaxSuspiciousVehicle(){
        $vName = I('vName');
        $name = I('name');
        $IdNumber = I('IdNumber');
        $driving_license = I('driving_license');
        $BusinessName = I('BusinessName');
        $startTime = I('startTime');//起始时间
        if($vName != ''){
            $c['vName'] = $vName;
        }else{
            $c['vName'] = '';
        }
        if($name != ''){
            $c['name'] = $name;
        }else{
            $c['name'] = '';
        }
        if($IdNumber != ''){
            $c['IdNumber'] = $IdNumber;
        }else{
            $c['IdNumber'] = '';
        }
        if($driving_license != ''){
            $c['driving_license'] = $driving_license;
        }else{
            $c['driving_license'] = '';
        }
        if($BusinessName != ''){
            $c['BusinessName'] = $BusinessName;
        }else{
            $c['BusinessName'] = '';
        }
        $c['ITime'] = $startTime;

        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;

        $arr_json = json_encode($c);
        $arr_json = str_replace(' ','%20',$arr_json);
        //requestApi/bs_Taxi?type=SuspiciousVehicle&jsonStr={"vName":"京BP1535","name":"胡志刚","IdNumber":"11022619710426031X","driving_license":"268708","BusinessName":"北京首汽（集团）股份有限公司","ITime":"2016-07-16"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=SuspiciousVehicle&jsonStr=".$arr_json);

        //echo C("URL_BEFORE")."/requestApi/bs_Taxi?type=SuspiciousVehicle&jsonStr=".$arr_json;
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }

    /**
     * 入库
     */
    function addSuspiciousVehicle(){
    	$this->assign ( "startDate", date ( 'Y-m-d H:i:s', time () ));
    	$this->display("addSuspiciousVehicle");
    }
    function ajaxaddSuspiciousVehicle(){
        //车牌号码,入库时间,入库说明,可疑库类型,可疑项节点代码列表,案底库的违法行为,操作人员
        //requestApi/bs_Taxi?type=addSuspiciousVehicle&jsonStr={"CPH":"京BR3121","CZY":"貂蝉","RKSJ":"2016-09-05 11:01:30","RKSM":"轨迹长","KYK_LX":"可疑长度","KYX_BMS":"拒客","ADK_WFXW":"有案底"}
        //http://123.57.236.212:8080/requestApi/bs_Taxi?type=addSuspiciousVehicle&jsonStr={%22CPH%22:%22\u5dddA12345%22,%22CZY%22:%22\u6d4b\u8bd5%22,%22RKSJ%22:%222016-09-05%2017:48:59%22,%22RKSM%22:%22\u6d4b\u8bd5%22,%22KYK_LX%22:%22\u6d4b\u8bd5%22,%22KYX_BMS%22:%22\u6d4b\u8bd5%22,%22ADK_WFXWADK_WFXW%22:%22\u6d4b\u8bd5%22}
        $CPH = I('CPH');
        $CZY = I('CZY');
        $RKSJ = I('startTime');
        $RKSM = I('RKSM');//入库说明
        $KYK_LX = I('KYK_LX');
        $KYX_BMS = I('KYX_BMS');
        $ADK_WFXW = I('ADK_WFXW');
        if($CPH != ''){
            $c['CPH'] = $CPH;
        }else{
            $c['CPH'] = '';
        }
        if($CZY != ''){
            $c['CZY'] = $CZY;
        }else{
            $c['CZY'] = '';
        }
        if($RKSJ != ''){
            $c['RKSJ'] = $RKSJ;
        }else{
            $c['RKSJ'] = '';
        }
        if($RKSM != ''){
            $c['RKSM'] = $RKSM;
        }else{
            $c['RKSM'] = '';
        }
        if($KYK_LX != ''){
            $c['KYK_LX'] = $KYK_LX;
        }else{
            $c['KYK_LX'] = '';
        }
        if($KYX_BMS != ''){
            $c['KYX_BMS'] = $KYX_BMS;
        }else{
            $c['KYX_BMS'] = '';
        }
        if($ADK_WFXW != ''){
            $c['ADK_WFXW'] = $ADK_WFXW;
        }else{
            $c['ADK_WFXW'] = '';
        }
        $c['CREATE_DATE'] = date('Y-m-d H:i:s',time());
        $c['UPDATE_DATE'] = date('Y-m-d H:i:s',time());
        //p($c);
    	$arr_json = json_encode($c);
        $arr_json = str_replace(' ','%20',$arr_json);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=addSuspiciousVehicle&jsonStr=".$arr_json);
       // echo C("URL_BEFORE")."/requestApi/bs_Taxi?type=addSuspiciousVehicle&jsonStr=".$arr_json;
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }

    /**
     * 出库
     */
    function outSuspiciousVehicle(){
        $id = I("id");
        $this->assign ( "id", $id);
        $this->assign ( "startDate", date ( 'Y-m-d H:i:s', time () ));
        $this->display("outSuspiciousVehicle");
    }
    function ajaxoutSuspiciousVehicle(){
        //requestApi/bs_Taxi?type=outSuspiciousVehicle&jsonStr={"ID":"123123123123","CKSJ":"2016-09-05 11:01:30","CKSM":"轨迹长","CZY":"貂蝉"}
        $id = I("id");
        $CKSJ = I("startTime");//date ( 'Y-m-d H:i:s', time () );//出库时间
        $CKSM = I("CKSM");//说明
        $CZY = I("CZY");

        $c['ID'] = $id;
        $c['CKSJ'] = $CKSJ;
        $c['CKSM'] = $CKSM;
        $c['CZY'] = $CZY;

        $arr_json = json_encode($c);
        $arr_json = str_replace(' ','%20',$arr_json);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=outSuspiciousVehicle&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }
}