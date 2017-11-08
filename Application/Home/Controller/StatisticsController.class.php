<?php
namespace Home\Controller;
use Think\Controller;

class StatisticsController extends BestController{
    /**
     * 车组执法稽查数量统计表
     */


    //法制处的统计表
    function FzcjcList(){
        $last_month = date('Y-m', strtotime('last month'));
        $last['first'] = $last_month . '-01 00:00:00';
        //$last['end'] = date('Y-m-d H:i:s', strtotime("$last_month +1 month -1 day +23 hours +59 minutes +59 seconds"));
        $last['end'] = date('Y-m-d H:i:s',time());
        $today = date('Y-m-d H:i:s',time());
        $this->assign ( "startDate", $last['first'] );
        $this->assign ( "today", $today );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", $last['end']  );
        //大队
        $compName =  getCompName();
        $urc_hy = C('HY');
        $this->assign('compName',$compName);
        $this->assign("urc_hy",$urc_hy);
        //$this->assign("compName",$compName);
        $this->assign("check",2);
        $this->display("FzcjcList");
    }
    function ajaxFzcjcList()
    {

        $offset = I('offset');
        $maxrows = I('maxrows');
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间
        $zt = I('zt');
        $hy = I('hy');
        $dd = I('dd');
        $CITIZEN_NAME = I('CITIZEN_NAME');
        $MODULE_NAME = I('MODULE_NAME');
        $check = I('check');
        
        /*if (empty($hy) && empty($zt) && empty($CITIZEN_NAME) && empty($MODULE_NAME) && empty($startTime) && empty($endTime)) {
            $R_json = postHttp(C("URL_BEFORE")."/requestApi/special?type=getZfbInfo");
            $R = json_decode($R_json, true);
        } else {*/
        if ($zt == '未提交'){
            $FLAG = '0';
            $FZB_FLAG = '';
        }elseif ($zt == '提交成功'){
            $FLAG = '1';
            $FZB_FLAG = true;
        }elseif ($zt == '提交失败'){
            $FLAG = '1';
            $FZB_FLAG = false;
        }elseif ($zt == '提交中'){
            $FLAG = '1';
            $FZB_FLAG = '0';
        }else{
            $FLAG = '';
            $FZB_FLAG = '';
        }
        if($offset>0){
            $offset = $offset+1;
        }
        ///requestApi/special?type=getZfbInfo&jsonStr={"HYLB":"旅游客运","CITIZEN_NAME":"","STARTDATE":"","ENDDATE":"","MODULE_NAME":"","IS_ENABLE":"","startIndex":0,"endIndex":5}
        $ZFZH = $_SESSION['admin']['name'];
        $nzt = '';
        $arr = array(
            'HYLB' => $hy,
            'CITIZEN_NAME' => $CITIZEN_NAME,
            'STARTDATE' => date('Y-m-d H:i:s',strtotime($startTime)),
            'ENDDATE' => date('Y-m-d H:i:s',strtotime($endTime)),
            'MODULE_NAME' => $MODULE_NAME,
            'IS_ENABLE' => $nzt,
            'startIndex' => $offset,
            'endIndex' => $offset+$maxrows,
            'FLAG' => $FLAG,
            'FZB_FLAG' => $FZB_FLAG,
            'ZFZH' => $ZFZH,
            'ZFDWMC'=>$dd
        );
        $arr_json = json_encode($arr);
        //echo $arr_json;
        ////requestApi/special?type=getZfbInfo&jsonStr={"HYLB":"旅游客运","CITIZEN_NAME":"","STARTDATE":"","ENDDATE":"","MODULE_NAME":"","IS_ENABLE":"","startIndex":0,"endIndex":5,"FLAG":"","FZB_FLAG":""}
        $R_json2 = postHttp(C("URL_BEFORE")."/requestApi/special?type=getZfbInfo",array("jsonStr"=>$arr_json));

        $R_jsonss = json_decode($R_json2,true);
        //p($R_jsons);null  false  true
        $R_json = $R_jsonss[0]['rows'];
        foreach ($R_json as $k => $v) {
            $zf[$k] = explode(',',$v['PERSON_NAME']);
            $R_json[$k]['zf1'] = $zf[$k][0];
            $R_json[$k]['zf2'] = $zf[$k][1];
            if($v['FLAG']==0){
                $R_json[$k]['submit_result'] = '未提交';
            }else{
                if($v['RET_FLAG']=='true'){
                    $R_json[$k]['submit_result'] = '提交成功';
                }elseif($v['RET_FLAG']=='false'){
                    $R_json[$k]['submit_result'] = '提交失败';
                }else{
                    $R_json[$k]['submit_result'] = '提交中';
                }
            }
            $RES_DES = json_decode($v['RET_DES'],true);
            if ($v['RET_DES'] == ''){
                $R_json[$k]['RET_DES'] = '';
            }
            //print_r($RES_DES);
            if ($RES_DES['RET_FLAG'] == 1){
                $R_json[$k]['RET_DES'] = '';
            }elseif ($RES_DES['RET_FLAG'] == ''){
                $str = $RES_DES['error'];
                $str2 = preg_replace( '/\((.*)\)/', '',$str);
                $str3 = preg_replace( '/\（(.*)\）/', '',$str2);
                $R_json[$k]['RET_DES'] = $str3;
            }
        }

        //p($R_json);
        /*foreach ($R_json as $k=>$v){
            $zf = explode(',',$v['PERSON_NAME']);
            $v['zf1'] = $zf[0];
            $v['zf2'] = $zf[1];
            
            if($v['FLAG']==0){
                $v['RET_FLAG'] = '未提交';
            }else{
                $R_jsons1[$k] = postHttp(C("URL_BEFORE")."/requestApi/special?type=getFzbResult&id=".$v['ZID']);
                $R_jsons[$k] = json_decode($R_jsons1[$k],true);
                if($R_jsons[$k][0]['RET_FLAG']=='true'){
                   $v['RET_FLAG'] = '提交成功';
                }elseif($R_jsons[$k][0]['RET_FLAG']=='false'){
                    $v['RET_FLAG'] = '提交失败';
                }else{
                    $v['RET_FLAG'] = '提交中';
                }
                
            }
            $R_json1[] = $v;
        }*/
        //P($R_jsons[0]);
        //p($R_jsonss[0]['total']);
        $Res['rows'] = $R_json;
        $Res['total'] = $R_jsonss[0]['total'];
        $this->ajaxReturn($Res);
    }
    //修改信息
    function FzcjcEdit(){
        $id = I('id');
        $c['id'] = $id;
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/special?type=getZfbInfo_bs&jsonStr=".$arr_json);
        $arra = json_decode($R_json,true);
        foreach ($arra as $v){
            $arr = $v;
        }
        $this->assign('arr',$arr);
        $this->display('editFzcjcList');
    }

    //详细信息
    function FzcjcView(){

        $id = I('id');
        $c['id'] = $id;
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/special?type=getZfbInfo_bs&jsonStr=".$arr_json);
        $arra = json_decode($R_json,true);
        foreach ($arra as $v){
            $arr = $v;
        }
        $this->assign('arr',$arr);
        $this->display('viewFzcjcList');
    }
    function ajaxeditFzcjcList(){
        $CHECK_LIST_CODE = I('CHECK_LIST_CODE');
        $ZID = I('ZID');
        $ADDRESS = I('ADDRESS');
        $VNAME = I('VNAME');
        $SFZH = I('SFZH');
        $CHECK_DATE = I('CHECK_DATE');
        $PERSON_ID = I('PERSON_ID');
        $T3ORGANIZATION_ID = I('T3ORGANIZATION_ID');
        $PERSON_CODE = I('PERSON_CODE');
        $T3IS_DELETE = I('T3IS_DELETE');
        $PERSON_NAME = I('PERSON_NAME');
        $MODULE_NAME = I('MODULE_NAME');
        $T2IS_DELETE = I('T2IS_DELETE');
        $IS_STANDARD = I('IS_STANDARD');
        $MODULE_ID = I('MODULE_ID');
        $CHECK_ITEM_NAME = I('CHECK_ITEM_NAME');
        $CHECK_ITEM_ID = I('CHECK_ITEM_ID');
        $IS_ENABLE = I('IS_ENABLE');
        $CHECK_LIST_NAME = I('CHECK_LIST_NAME');
        $T1IS_DELETE = I('T1IS_DELETE');
        $CHECK_LIST_ID = I('CHECK_LIST_ID');
        $CREATE_USER_CODE = I('CREATE_USER_CODE');
        $CREATE_TIME = I('CREATE_TIME');
        $CREATE_USER_ID = I('CREATE_USER_ID');
        $CREATE_USER_NAME = I('CREATE_USER_NAME');
        $PUNISHMENT_TYPE = I('PUNISHMENT_TYPE');
        $IS_SUBMIT = I('IS_SUBMIT');
        $REVIEW_RESULT_EXPLAIN = I('REVIEW_RESULT_EXPLAIN');
        $ORGANIZATION_ID = I('ORGANIZATION_ID');
        $TIS_DELETE = I('TIS_DELETE');
        $REVIEW_RESULT = I('REVIEW_RESULT');
        $REVIEW_DATE = I('REVIEW_DATE');
        $DEAL_STATE = I('DEAL_STATE');
        $CHECK_PLACE = I('CHECK_PLACE');
        $PEOPLE_TYPE = I('PEOPLE_TYPE');
        $CITIZEN_NAME = I('CITIZEN_NAME');
        $CITIZEN_PHONE = I('CITIZEN_PHONE');
        $UNIT_NAME = I('UNIT_NAME');
        $LEGAL_PERSON = I('LEGAL_PERSON');
        $LEGAL_PERSON_PHONE = I('LEGAL_PERSON_PHONE');
        $ORGANIZATION_NAME = I('ORGANIZATION_NAME');
        $ORGANIZATION_PERSON = I('ORGANIZATION_PERSON');
        $ORGANIZATION_PHONE = I('ORGANIZATION_PHONE');
        $CHECK_RESULT = I('CHECK_RESULT');
        $CHECK_EXPLAIN = I('CHECK_EXPLAIN');
        $IS_CHARGE_REFORM = I('IS_CHARGE_REFORM');
        $CHARGE_REFORM = I('CHARGE_REFORM');
        $REFORM_RESULT = I('REFORM_RESULT');
        $REFORM_START_DATE = I('REFORM_START_DATE');
        $REFORM_END_DATE = I('REFORM_END_DATE');
        $IS_PUNISHMENT = I('IS_PUNISHMENT');
        $arry['CHECK_LIST_CODE'] = $CHECK_LIST_CODE;
        $arry['ZID'] = $ZID;
        $arry['ADDRESS'] = $ADDRESS;
        $arry['VNAME'] = $VNAME;
        $arry['SFZH'] = $SFZH;
        $arry['CHECK_DATE'] = $CHECK_DATE;
        $arry['PERSON_ID'] = $PERSON_ID;
        $arry['T3ORGANIZATION_ID'] = $T3ORGANIZATION_ID;
        $arry['PERSON_CODE'] = $PERSON_CODE;
        $arry['T3IS_DELETE'] = $T3IS_DELETE;
        $arry['PERSON_NAME'] = $PERSON_NAME;
        $arry['MODULE_NAME'] = $MODULE_NAME;
        $arry['CHECK_ITEM_NAME'] = $CHECK_ITEM_NAME;
        $arry['T2IS_DELETE'] = $T2IS_DELETE;
        $arry['IS_STANDARD'] = $IS_STANDARD;
        $arry['MODULE_ID'] = $MODULE_ID;
        $arry['CHECK_ITEM_ID'] = $CHECK_ITEM_ID;
        $arry['IS_ENABLE'] = $IS_ENABLE;
        $arry['CHECK_LIST_NAME'] = $CHECK_LIST_NAME;
        $arry['T1IS_DELETE'] = $T1IS_DELETE;
        $arry['CHECK_LIST_ID'] = $CHECK_LIST_ID;
        $arry['CREATE_USER_CODE'] = $CREATE_USER_CODE;
        $arry['CREATE_TIME'] = $CREATE_TIME;
        $arry['CREATE_USER_ID'] = $CREATE_USER_ID;
        $arry['CREATE_USER_NAME'] = $CREATE_USER_NAME;
        $arry['PUNISHMENT_TYPE'] = $PUNISHMENT_TYPE;
        $arry['IS_SUBMIT'] = $IS_SUBMIT;
        $arry['REVIEW_RESULT_EXPLAIN'] = $REVIEW_RESULT_EXPLAIN;
        $arry['ORGANIZATION_ID'] = $ORGANIZATION_ID;
        $arry['TIS_DELETE'] = $TIS_DELETE;
        $arry['REVIEW_RESULT'] = $REVIEW_RESULT;
        $arry['REVIEW_DATE'] = $REVIEW_DATE;
        $arry['DEAL_STATE'] = $DEAL_STATE;
        $arry['CHECK_PLACE'] = $CHECK_PLACE;
        $arry['PEOPLE_TYPE'] = $PEOPLE_TYPE;
        $arry['CITIZEN_NAME'] = $CITIZEN_NAME;
        $arry['CITIZEN_PHONE'] = $CITIZEN_PHONE;
        $arry['UNIT_NAME'] = $UNIT_NAME;
        $arry['LEGAL_PERSON'] = $LEGAL_PERSON;
        $arry['LEGAL_PERSON_PHONE'] = $LEGAL_PERSON_PHONE;
        $arry['ORGANIZATION_NAME'] = $ORGANIZATION_NAME;
        $arry['ORGANIZATION_PERSON'] = $ORGANIZATION_PERSON;
        $arry['ORGANIZATION_PHONE'] = $ORGANIZATION_PHONE;
        $arry['CHECK_RESULT'] = $CHECK_RESULT;
        $arry['CHECK_EXPLAIN'] = $CHECK_EXPLAIN;
        $arry['IS_CHARGE_REFORM'] = $IS_CHARGE_REFORM;
        $arry['CHARGE_REFORM'] = $CHARGE_REFORM;
        $arry['REFORM_RESULT'] = $REFORM_RESULT;
        $arry['REFORM_START_DATE'] = $REFORM_START_DATE;
        $arry['REFORM_END_DATE'] = $REFORM_END_DATE;
        $arry['IS_PUNISHMENT'] = $IS_PUNISHMENT;
        $arr_json = json_encode($arry);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/special?type=updateFzbInfo",array("jsonStr"=>$arr_json));
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    function ajaxDelFzcjc()
    {

        $id = I('id');
        /*if (empty($hy) && empty($zt) && empty($CITIZEN_NAME) && empty($MODULE_NAME) && empty($startTime) && empty($endTime)) {
            $R_json = postHttp(C("URL_BEFORE")."/requestApi/special?type=getZfbInfo");
            $R = json_decode($R_json, true);
        } else {*/
        //$str = implode(',',array($id));
        $arr = array(
            'id' =>"'".$id."'"
        );
        $arr_json = json_encode($arr);
        //echo $arr_json;
        //$R_json2 = postHttp(C("URL_BEFORE")."/requestApi/special?type=delFzbInfo",array("jsonStr"=>$arr_json));
        $R_json2 = postHttp(C("URL_BEFORE")."/requestApi/special?type=delFzbInfo&jsonStr=".$arr_json);
        //echo C("URL_BEFORE")."/requestApi/special?type=delFzbInfo&jsonStr=".$arr_json;
        $R_json = json_decode($R_json2,true);
        //print_r($arr);
        $this->ajaxReturn($R_json);
    }
    function ajaxDelAllFzcjc()
    {

        $id = I('id');
        $str = rtrim($id, ",");
        //echo $str;
        //$str = implode(',',array($id));
        $arr = array(
            'id' =>$str
        );
        $arr_json = json_encode($arr);
        //echo $arr_json;
        //$R_json2 = postHttp(C("URL_BEFORE")."/requestApi/special?type=delFzbInfo",array("jsonStr"=>$arr_json));
        $R_json2 = postHttp(C("URL_BEFORE")."/requestApi/special?type=delFzbInfo&jsonStr=".$arr_json);
        //echo C("URL_BEFORE")."/requestApi/special?type=delFzbInfo&jsonStr=".$arr_json;
        $R_json = json_decode($R_json2,true);
        //print_r($arr);
        $this->ajaxReturn($R_json);
    }
    function ajaxSubFzcjc()
    {

        $id = I('id');
        /*if (empty($hy) && empty($zt) && empty($CITIZEN_NAME) && empty($MODULE_NAME) && empty($startTime) && empty($endTime)) {
            $R_json = postHttp(C("URL_BEFORE")."/requestApi/special?type=getZfbInfo");
            $R = json_decode($R_json, true);
        } else {*/
        //$str = implode(',',array($id));
        $arr = array(
            'id' =>"'".$id."'"
        );
        $arr_json = json_encode($arr);
        //echo $arr_json;
        //$R_json2 = postHttp(C("URL_BEFORE")."/requestApi/special?type=delFzbInfo",array("jsonStr"=>$arr_json));
        $R_json2 = postHttp(C("URL_BEFORE")."/requestApi/special?type=commitFzbInfoToService&jsonStr=".$arr_json);
        //echo C("URL_BEFORE")."/requestApi/special?type=delFzbInfo&jsonStr=".$arr_json;
        $R_json = json_decode($R_json2,true);
        if($R_json['status']==500){
            $this->ajaxReturn(array('error'=>500,'msg'=>'系统异常'));
        }
        //print_r($arr);
        $this->ajaxReturn($R_json);
    }
    function ajaxSubAllFzcjc()
    {

        $id = I('id');
        $str = rtrim($id, ",");
        //echo $str;
        //$str = implode(',',array($id));
        $arr = array(
            'id' =>$str
        );
        $arr_json = json_encode($arr);
        //echo $arr_json;
        //$R_json2 = postHttp(C("URL_BEFORE")."/requestApi/special?type=delFzbInfo",array("jsonStr"=>$arr_json));
        $R_json2 = postHttp(C("URL_BEFORE")."/requestApi/special?type=commitFzbInfoToService&jsonStr=".$arr_json);
        //echo C("URL_BEFORE")."/requestApi/special?type=delFzbInfo&jsonStr=".$arr_json;
        $R_json = json_decode($R_json2,true);
        //print_r($arr);
        $this->ajaxReturn($R_json);
    }
    /**
     * 车组执法稽查数量统计表
     */
   function CzLawList(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60)) );

        $this->assign("check",2);
        $this->display("CzLawList");
   }
   function ajaxCzLawList(){
        //cz(车组),(hy)行业,(startTime)起始时间,(endTime)结束时间
        $hylb = I('hy');//行业
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间

        //{"driverName":"白生志","cyzg":"267626","vName":"京BU1872","startTime":"1471366800","endTime":"1471446000","dd":"北京市交通执法总队首都机场执法大队","zd":"一中队","cz":"一车组","num":"123","corpName":"京东","startIndex":0,"endIndex":5}
      
        if($hylb != '全部'){
            $c['hylb'] = $hylb;
        }else{
            $c['hylb'] = '';
        }
        
        $c['startTime'] = strtotime($startTime);
        $c['endTime'] = strtotime($endTime);

        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows;
        //123.57.236.212:8080/requestApi/bs_Taxi?type=AuditingList&jsonStr={"cz":"","startTime":1469980800,"endTime":1471881599,"startIndex":"0","endIndex":"10"}
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=CzLawList&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        for ($i=0; $i <count($R['rows']); $i++) { 
            $R['rows'][$i]['id'] = $i+1;
            $R['rows'][$i]['count'] = $R['rows'][$i]['STAT0']+$R['rows'][$i]['STAT2']+$R['rows'][$i]['STAT3']+$R['rows'][$i]['STAT4']+$R['rows'][$i]['STAT5'];
        }
        $this->ajaxReturn ($R);
   }
   /**
     * 详情(废除)
     */
    function CzLawDetail(){
        $num = I('num');
        $c['num'] = $num;
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=CzLawDetail&jsonStr=".$arr_json);
                $R = json_decode($R_json,true);
                //p($R);
                $this->assign ( "R", $R['rows'][0] );
        $this->display("CzLawDetail");
    }

    /******************************/
    /**
     * 大队执法稽查数量统计表
     */
   function DdLawList(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60)) );

        $this->assign("check",2);
        $this->display("DdLawList");
   }
   function ajaxDdLawList(){
        $hylb = I('hy');//行业
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间

        //{"driverName":"白生志","cyzg":"267626","vName":"京BU1872","startTime":"1471366800","endTime":"1471446000","dd":"北京市交通执法总队首都机场执法大队","zd":"一中队","cz":"一车组","num":"123","corpName":"京东","startIndex":0,"endIndex":5}
      
        if($hylb != '全部'){
            $c['hylb'] = $hylb;
        }else{
            $c['hylb'] = '';
        }
        
        $c['startTime'] = strtotime($startTime);
        $c['endTime'] = strtotime($endTime);

        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows;
        //123.57.236.212:8080requestApi/bs_Taxi?type=DdLawList&jsonStr={"hylb":"","startTime":1469980800,"endTime":1471967999,"startIndex":"0","endIndex":"10"}
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=DdLawList&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        for ($i=0; $i <count($R['rows']); $i++) { 
            $R['rows'][$i]['id'] = $i+1;
            $R['rows'][$i]['count'] = $R['rows'][$i]['STAT0']+$R['rows'][$i]['STAT2']+$R['rows'][$i]['STAT3']+$R['rows'][$i]['STAT4']+$R['rows'][$i]['STAT5'];
        }
        $this->ajaxReturn ($R);
   }
   /**
     * 详情
     */
    function DdLawDetail(){
        $num = I('num');
        $c['num'] = $num;
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=DdLawDetail&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
                //p($R);
        $this->assign ( "R", $R['rows'][0] );
        $this->display("DdLawDetail");
    }
    /**
     * 执法考核对比表(日)
     */
    function LawContrastAllList(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01" );
        //$this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );

        $this->assign("check",2);
        $this->display("LawContrastAllList");

    }
    function ajaxLawContrastAllList(){
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
        $startTime = I('startTime');//起始时间

        $c['Time'] = strtotime($startTime);
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=LawContrastAllList&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $R1 = $R['rows'];
        //p($R);
        //echo C("URL_BEFORE")."/requestApi/bs_Taxi?type=LawContrastAllList&jsonStr=".$arr_json;
        $arr['time'] = date('Y年m月d日',strtotime($startTime));
        $arr['name'] = '违规';
        $arr['name1'] = '正常';
        for ($i=0; $i < count($R1); $i++) {
            $arr['rows'][$i]['name'] = $R1[$i]['name'];
            $arr['rows1'][$i]['name'] = $R1[$i]['name'];
            for ($j=0; $j < count($R1[$i]['data']); $j++) { 
                $arr['rows'][$i]['data'][$j] = $R1[$i]['data'][$j]['STAT1'];//0正常  1违规
                $arr['rows1'][$i]['data'][$j] = $R1[$i]['data'][$j]['STAT0'];//0正常  1违规
            }
        }
/*p($arr);
die;*/
        $R = $arr;
        $this->ajaxReturn ($R);

    }
    /**
     * (月)
     */
    function MLawContrastAllList(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01" );
        //$this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );

        $this->assign("check",2);
        $this->display("MLawContrastAllList");

    }
    function ajaxMLawContrastAllList(){
        $startTime = I('startTime');//起始时间

        $c['Time'] = strtotime($startTime);
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=MLawContrastAllList&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $R1 = $R['rows'];
        //p($R);
        $arr['time'] = date('Y年m月',strtotime($startTime));
        $arr['name'] = '违规';
        $arr['name1'] = '正常';
        for ($i=0; $i < count($R1); $i++) {
            $arr['rows'][$i]['name'] = $R1[$i]['name'];
            $arr['rows1'][$i]['name'] = $R1[$i]['name'];
            for ($j=0; $j < count($R1[$i]['data']); $j++) { 
                $arr['rows'][$i]['data'][$j] = $R1[$i]['data'][$j]['STAT1'];//0正常  1违规
                $arr['rows1'][$i]['data'][$j] = $R1[$i]['data'][$j]['STAT0'];//0正常  1违规
            }
        }
/*p($arr);
die;*/
        $R = $arr;
        $this->ajaxReturn ($R);
    }

    /**
     * 执法稽查数量统计表
     */
    public function getStatisticsF(){

        $this->assign ( "startDate", date ( 'Y-m-1', strtotime('-1 month') ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60))  );
       
        $compName = getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",2);
          
            
        $this->display("statistics_frist");
    }
    function ajaxStatisticsF(){
        //requestApi/xinxi?type=queryRegisterInfo&jsonStr={"totalNum":0,"startIndex":0,"endIndex":10,"vname":null,"driverName":null,"corpName":null,"hylb":"出租车","code":null,"cyzgz":null,"zfdwmc":"五大队","startTime":"2649618","endTime":"1470214823","zfry1":null,"status":null,"sszd":"一中队","sscz":"一车组"}
        $hylb = I('hy');
        $zfdwmc = I('dd');
        $sszd = I('zd');
        $sscz = I('cz');
        $startDate = I('startTime')?I('startTime'):'2000-01-01 00:00:00';//开始时间
        $endDate = I('endTime')?I('endTime'):date('Y-m-d H:i:s');//结束时间

        $c['totalNum'] = 0;
        $c['vname'] = '';
        $c['driverName'] = '';
        $c['corpName'] = '';
        $c['code'] = '';
        $c['cyzgz'] = '';
        $c['zfry1'] = '';
        $c['status'] = '';
        if($hylb != '全部'){
            $c['hylb'] = $hylb;
        }else{
            $c['hylb'] = '';
        }
        if($zfdwmc != '全部'){
            $c['zfdwmc'] = $zfdwmc;
        }else{
            $c['zfdwmc'] = '';
        }
        if($sszd != '全部'){
            $c['sszd'] = $sszd;
        }else{
            $c['sszd'] = '';
        }
        if($sscz != '全部'){
            $c['sscz'] = $sscz;
        }else{
            $c['sscz'] = '';
        }

        $c['startTime'] = strtotime($startDate);
        $c['endTime']   = strtotime($endDate);
        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;
        $R_json = json_encode($c);
     
        $R1_json = postHttp(C("URL_BEFORE")."/requestApi/xinxi?type=queryRegisterInfo&jsonStr=".$R_json);
        $R1 = json_decode($R1_json,true);
        //echo C("URL_BEFORE")."/requestApi/xinxi?type=queryRegisterInfo&jsonStr=".$R_json;
        //p($R1);
        $R['total']  = count($R1);
        $R['rows'] = $R1;
        for ($i=0; $i < count($R1); $i++) { 
            $R['rows'][$i]['key'] = $i+1;
        }
         
        $this->ajaxReturn ($R);

    }

    /**
     * 北京市交通执法总队执法稽查数量统计表
     */
    public function getStatisticsS(){

        $this->assign ( "startDate", date ( 'Y-m-1', strtotime('-1 month') ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60)) );
       
        $compName = getCompName();
        $this->assign("compName",$compName);
        $this->assign("check",2);
          
            
        $this->display("statistics_secend");
    }
    function ajaxStatisticsS(){
        //requestApi/xinxi?type=queryRegisterInfo&jsonStr={"totalNum":0,"startIndex":0,"endIndex":10,"vname":null,"driverName":null,"corpName":null,"hylb":"出租车","code":null,"cyzgz":null,"zfdwmc":"五大队","startTime":"2649618","endTime":"1470214823","zfry1":null,"status":null,"sszd":"一中队","sscz":"一车组"}
        $hylb = I('hy');
        $zfdwmc = I('dd');
        $sszd = I('zd');
        $sscz = I('cz');
        $startDate = I('startTime')?I('startTime'):'2000-01-01 00:00:00';//开始时间
        $endDate = I('endTime')?I('endTime'):date('Y-m-d H:i:s');//结束时间

        $c['totalNum'] = 0;
        $c['vname'] = '';
        $c['driverName'] = '';
        $c['corpName'] = '';
        $c['code'] = '';
        $c['cyzgz'] = '';
        $c['zfry1'] = '';
        $c['status'] = '';
        if($hylb != '全部'){
            $c['hylb'] = $hylb;
        }else{
            $c['hylb'] = '';
        }
        if($zfdwmc != '全部'){
            $c['zfdwmc'] = $zfdwmc;
        }else{
            $c['zfdwmc'] = '';
        }
        if($sszd != '全部'){
            $c['sszd'] = $sszd;
        }else{
            $c['sszd'] = '';
        }
        if($sscz != '全部'){
            $c['sscz'] = $sscz;
        }else{
            $c['sscz'] = '';
        }

        $c['startTime'] = strtotime($startDate);
        $c['endTime']   = strtotime($endDate);
        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;
        $R_json = json_encode($c);
     
        $R1_json = postHttp(C("URL_BEFORE")."/requestApi/xinxi?type=queryRegisterInfo&jsonStr=".$R_json);
        $R1 = json_decode($R1_json,true);
        //echo C("URL_BEFORE")."/requestApi/xinxi?type=queryRegisterInfo&jsonStr=".$R_json;
        //p($R1);
        $R['total']  =  count($R1);
        $R['rows'] = $R1;
        for ($i=0; $i < count($R1); $i++) { 
            $R['rows'][$i]['key'] = $i+1;
        }
         
        $this->ajaxReturn ($R);

    }

    //法制办返回状态
    function getFzbResult(){
        //http://10.212.160.180:9876/requestApi/special?type=getFzbResult&id=bf4cb10740cd42f38f934338338a18a4
        $id = I('id');
        $R_json2 = postHttp(C("URL_BEFORE")."/requestApi/special?type=getFzbResult&id=".$id);
        $R_json = json_decode($R_json2,true);
        
        if($R_json['status']==500){
            $this->ajaxReturn(array('error'=>500,'msg'=>'系统异常'));
        }
        $this->ajaxReturn($R_json);
    }



}