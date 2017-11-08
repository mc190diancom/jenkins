<?php 
namespace Home\Controller;
use Think\Controller;
/**
 * 查询模块
 */
class TaxiQueryController extends BestController{
    function AuditingList(){
		$this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
		//$this->assign ( "startDate", "2016-08-01 00:00:00" );
		$this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );
		$common = A('Common');
		$HY_taxi = $common->get_jclb();
        $rode = $_SESSION['admin']['rode'];
		//p($HY_taxi);
		$this->assign("HY_taxi",$HY_taxi);
		//大队
		$compName =  getCompName();
		$this->assign("compName",$compName);
        $this->assign("rode",$rode);
        $this->assign("check",1);
        $this->display("AuditingList");
	}
	function ajaxAuditingList(){
		$dd = I('dd');//大队
		$zd = I('zd');//中队
		$cz = I('cz');//车组
		$num = I('num');//稽查编号
		$startTime = I('startTime');//起始时间
		$endTime = I('endTime');//结束时间
		$driverName = I('driverName');//驾驶员姓名
		$vName = I('vName');//车牌号码
		$corpName = I('corpName');//企业名称
		$cyzg = I('cyzg');//准驾证号

        //{"driverName":"白生志","cyzg":"267626","vName":"京BU1872","startTime":"1471366800","endTime":"1471446000","dd":"北京市交通执法总队首都机场执法大队","zd":"一中队","cz":"一车组","num":"123","corpName":"京东","startIndex":0,"endIndex":5}
        if($dd != '全部'){
        	$c['dd'] = $dd;
        }else{
        	$c['dd'] = '';
        }
        if($zd != '全部'){
        	$c['zd'] = $zd;
        }else{
        	$c['zd'] = '';
        }
        if($cz != '全部'){
        	$c['cz'] = $cz;
        }else{
        	$c['cz'] = '';
        }

        if($driverName != ''){
        	$c['driverName'] = $driverName;	
        }else{
        	$c['driverName'] = '';	
        }
        if($cyzg != ''){
        	$c['cyzg'] = $cyzg;
        }else{
        	$c['cyzg'] = '';	
        }
        if($vName != ''){
        	$c['vName'] = $vName;
        }else{
        	$c['vName'] = '';	
        }
        if($num != ''){
        	$c['num'] = $num;
        }else{
        	$c['num'] = '';	
        }
        if($corpName != ''){
        	$c['corpName'] = $corpName;
        }else{
        	$c['corpName'] = '';	
        }
        
        $c['startTime'] = strtotime($startTime);
        $c['endTime'] = strtotime($endTime);

        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;
        //123.57.236.212:8080/requestApi/bs_Taxi?type=AuditingList&jsonStr={"dd":"","zd":"","cz":"","driverName":"","cyzg":"","vName":"","num":"","corpName":"","startTime":1469980800,"endTime":1471535999,"startIndex":"0","endIndex":"10"}
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=AuditingList&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
	}

	/**
	 * 详情
	 */
	function AuditingDetail(){
		$num = I('num');
		$c['num'] = $num;
		$arr_json = json_encode($c);
		$R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=AuditingDetail&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
                //p($R);
        $this->assign ( "R", $R['rows'][0] );
		$this->display("AuditingDetail");
	}

	/**
	 * 修改页面
	 */
	function AuditingEdit(){
		//http://123.57.236.212:8080//requestApi/bs_Taxi?type=AuditingDetail&jsonStr={%22num%22:%22123%22}
		$num = I('num');
		/*$c['id'] = $num;
		$arr_json = json_encode($c);*/
		$R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=getInspectionInfoById&id=".$num);
        //echo C("URL_BEFORE")."/requestApi/bs_Taxi?type=getInspectionInfoById&id=".$num;
		$R = json_decode($R_json,true);
                //print_r($R);
                $this->assign ( "R", $R[0] );
		$this->display("AuditingEdit");
	}
	function ajaxAuditingEdit(){
		///requestApi/bs_Taxi?type=AuditingEdit&jsonStr={"num":"123","address":"乌江","vName":"","driverName":"","corpName":"","status":1,"hylb":"","zfsj":""}
		$num = I('num');
		$address = I('address');
		$vName = I('vName');
		$driverName = I('driverName');
		$corpName = I('corpName');
		$status = I('status');
		$hylb = I('hylb');
		$zfsj = I('zfsj');

		if($address != ''){
        	$c['address'] = $address;	
                }else{
                	$c['address'] = '';	
                }
                if($vName != ''){
                	$c['vName'] = $vName;	
                }else{
                	$c['vName'] = '';	
                }
                if($driverName != ''){
                	$c['driverName'] = $driverName;	
                }else{
                	$c['driverName'] = '';	
                }
                if($corpName != ''){
                	$c['corpName'] = $corpName;	
                }else{
                	$c['corpName'] = '';	
                }
                if($status != ''){
                	$c['status'] = $status;	
                }else{
                	$c['status'] = '';	
                }
                if($hylb != ''){
                	$c['hylb'] = $hylb;	
                }else{
                	$c['hylb'] = '';	
                }
                if($zfsj != ''){
                	$c['zfsj'] = strtotime($zfsj);	
                }else{
                	$c['zfsj'] = '';	
                }
        		$c['num'] = $num;
        		$arr_json = json_encode($c);

        		$R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=AuditingEdit&jsonStr=".$arr_json);
                $R = json_decode($R_json,true);
                $this->ajaxReturn ($R);
	}

	function AuditingDel(){
		$num = I('num');

		$c['num'] = $num;
		$arr_json = json_encode($c);

		$R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=AuditingDel&jsonStr=".$arr_json);
                $R = json_decode($R_json,true);
                /*$R = array(
                		'error' =>0,
                		'msg'=>'删除成功'
                	);*/
                $this->ajaxReturn ($R);
	}


    /************************************/
    /**
     * 出租汽车业内违规数量查询
     */
    function ViolationsList(){
            //(dd)大队,(zd)中队,(cz)车组,(startTime)起始时间,(endTime)结束时间
            //$this->assign ( "startDate", "2016-08-01 00:00:00" );
            $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
            $this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );
            $common = A('Common');
            $HY_taxi = $common->get_jclb();
            //p($HY_taxi);
            $this->assign("HY_taxi",$HY_taxi);
            //大队
            $compName =  getCompName();
            $this->assign("compName",$compName);
            $this->assign("check",1);
            $this->display("ViolationsList");

    }
    //接口 需求还没确定
    function ajaxViolationsList(){
            $dd = I('dd');//大队
            $zd = I('zd');//中队
            $cz = I('cz');//车组
            $startTime = I('startTime');//起始时间
            $endTime = I('endTime');//结束时间

            //123.57.236.212:8080/requestApi/bs_Taxi?type=ViolationsAllList&jsonStr={"dd":"北京市交通执法总队首都机场执法大队","zd":"三中队","cz":"二车组","startTime":"1470758400","endTime":"1471413822"}
            if($dd != '全部'){
                    $c['dd'] = $dd;
            }else{
                    $c['dd'] = '';
            }
            if($zd != '全部'){
                    $c['zd'] = $zd;
            }else{
                    $c['zd'] = '';
            }
            if($cz != '全部'){
                    $c['cz'] = $cz;
            }else{
                    $c['cz'] = '';
            }
            
            $c['startTime'] = strtotime($startTime);
            $c['endTime'] = strtotime($endTime);

            $offset = I('offset');
            $maxrows = I('maxrows');
            $c['startIndex'] = $offset;
            $c['endIndex'] = $maxrows;
            //123.57.236.212:8080/requestApi/bs_Taxi?type=AuditingList&jsonStr={"dd":"","zd":"","cz":"","driverName":"","cyzg":"","vName":"","num":"","corpName":"","startTime":1469980800,"endTime":1471535999,"startIndex":"0","endIndex":"10"}
            $arr_json = json_encode($c);
            $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=ViolationsList&jsonStr=".$arr_json);
            $R = json_decode($R_json,true);
            $this->ajaxReturn ($R);
    }


        

       

	
}