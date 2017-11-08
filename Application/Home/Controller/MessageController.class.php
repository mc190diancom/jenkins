<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/18
 * Time: 10:39
 */

namespace Home\Controller;


use Home\Model\FunctionModel;
use Home\Model\LoginModel;

class MessageController extends BestController
{
    //执法记录查询页面
    public function message_ac(){
        //print_r($_SESSION);
        /*if(IS_POST||(IS_GET && I('startTime'))){*/
            ////////////////////
          /*  if((I('hy')?I('hy'):'') == '--请选择--'){
                $c['hylb'] = '';//行业
            }else{
                $c['hylb'] = I('hy');//行业
            }
            $startDate = I('startTime')?I('startTime'):'2000-01-01 00:00:00';//开始时间
            $endDate = I('endTime')?I('endTime'):date('Y-m-d H:i:s');//结束时间
            $c['startTime'] = strtotime($startDate);
            $c['endTime']   = strtotime($endDate);
            if((I('zfdwmc')?I('zfdwmc'):'') == '--请选择--'){
                $c['zfdwmc'] = '';
            }else{
                $c['zfdwmc'] = I('zfdwmc');//大队
            }
            $c['code'] = '';
            $c['jdkh'] = '';
            if((I('zd')?I('zd'):'') == '--请选择--'){
                $c['zfry1'] = '';
            }else{
                $c['zfry1'] = I('zd');//稽查人员
            }
            //"code":"","jdkh":"","zfry1":"","driverName":"","vname":""}
            $c['driverName'] = I('driverName')?I('driverName'):'' ;//姓名
            $c['vname'] = I('vName')?I('vName'):'';//车牌号码
            
            //$R['corpName'] = I('corpName');//公司名称
            //$R['cyzgz'] = I('cyzg');//从业资格证


            $R2_json = json_encode($c);
            $url_b = C("URL_BEFORE");
            $url2   = $url_b."/requestApi/xinxi?type=get_Register_All&jsonStr=".$R2_json;
           
            $R2_json =  postHttp($url2);
            $R2 = json_decode($R2_json,true);
            for ($i=0; $i < count($R2); $i++) { 
                $Res[$i]['id'] = $i+1;
                $Res[$i]['ZFRY1'] = $R2[$i]['ZFRY1'];
                $Res[$i]['ZFDWMC'] = $R2[$i]['ZFDWMC'];
                $Res[$i]['CREATETIME'] = date('Y年m月d日',$R2[$i]['CREATETIME']);
                $Res[$i]['VNAME'] = $R2[$i]['VNAME'];
                $Res[$i]['DRIVERNAME'] = $R1[$i]['DRIVERNAME'];
                $Res[$i]['HYLB'] = $R2[$i]['HYLB'];
            }
             $this->assign('Res',$Res);*/

            ///////////////////////
           /* $R['totalNum'] = 0;

            $R['vname'] = I('vName')?I('vName'):'';//车牌号码
            $R['driverName'] = I('driverName')?I('driverName'):'';//姓名
            $R['corpName'] = I('corpName')?I('corpName'):'';//公司名称
            $R['cyzgz'] = I('cyzg');//从业资格证
            if((I('zfdwmc')?I('zfdwmc'):'') == '--请选择--'){
                $R['zfdwmc'] = '';
            }else{
                $R['zfdwmc'] = I('zfdwmc');//大队
            }
            if((I('zd')?I('zd'):'') == '--请选择--'){
                $R['zfry1'] = '';
            }else{
                $R['zfry1'] = I('zd');//稽查人员
            }
            if((I('hy')?I('hy'):'') == '--请选择--'){
                $R['hylb'] = '';//行业
            }else{
                $R['hylb'] = I('hy');//行业
            }

            $startDate = I('startTime')?I('startTime'):'2000-01-01 00:00:00';//开始时间
            $endDate = I('endTime')?I('endTime'):date('Y-m-d H:i:s');//结束时间
            $R['startTime'] = strtotime($startDate);
            $R['endTime']   = strtotime($endDate);

            $page = I('page')?I('page'):'';
            if($page == '')
            {
                $page = 1;
            }
            $R['startIndex'] = ($page-1)*10+0;
            $R['endIndex'] = ($page-1)*10+10;
            //p($R);
            //分页
            $R_json = json_encode($R);
            $url_b = C("URL_BEFORE");
            $url   = $url_b."/requestApi/xinxi?type=queryRegisterInfoByName&jsonStr=".$R_json;

            $R1_json =  postHttp($url);
            $R1 = json_decode($R1_json,true);
            $total  = $R1[0]['totalNum'];//总条数
            $times = ceil($total/10);//总页数
            $this->assign('page',$page);
            $this->assign('per',$page-1);
            $this->assign('next',$page+1);
            $this->assign('total',$total);
            $this->assign('times',$times);
            $this->assign('st',$startDate);
            $this->assign('en',$endDate);

            if((I('zd')?I('zd'):'') == '--请选择--'){
                $R['zfry1'] = '--请选择--';
            }else{
                $R['zfry1'] = I('zd');//稽查人员
            }
            if((I('hy')?I('hy'):'') == '--请选择--'){
                $R['hylb'] = '--请选择--';//行业
            }else{
                $R['hylb'] = I('hy');//行业
            }
            $R['driverName'] = I('driverName') ;//姓名
            $R['vName'] = I('vName');//车牌号码
            $R['zfdwmc'] = I('zfdwmc');

            if(I('zfdwmc') != ''){

            }else{
                $R['vname'] = '';//车牌号码
                $R['driverName'] = '' ;//姓名
                $R['corpName'] = '';//公司名称
                $R['cyzg'] = '';//从业资格证
                $R['zfdwmc'] = '--请选择--';//大队
                $R['zfry1'] = '--请选择--';//稽查人员
                $R['hylb'] = '--请选择--';//行业
                $startDate = '';//开始时间
                $endDate = '';//结束时间
            }
            $this->assign('c',$R);
            $this->assign("R1",$R1);
            $this->assign("check",1);

            $this->assign("startDate",$startDate);
            $this->assign("endDate",$endDate);
            if($total){
                 $this->assign('show','message_ac_end');
            }else{
                $this->assign('errormsg','暂无数据');
            }*/

        /*}else{
            $R['vname'] = '';//车牌号码
            $R['driverName'] = '' ;//姓名
            $R['corpName'] = '';//公司名称
            $R['cyzg'] = '';//从业资格证
            $R['zfdwmc'] = '--请选择--';//大队
            $R['zfry1'] = '--请选择--';//稽查人员
            $R['hylb'] = '--请选择--';//行业
            $startDate = '';//开始时间
            $endDate = '';//结束时间

            $this->assign('c',$R);
        }*/

        //$this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        $this->assign ( "startDate", date ( 'Y-m-1', strtotime('-1 year') ) . " 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time()-60 )) );
        $compName =  getCompName();
        $rode = $_SESSION['save'];
        $this->assign('show','message_ac_end');
        //$compName = json_decode($compName);
        // print_r($compName);
        $this->assign("rode",$rode);
        //$this->assign("hy",C("HY"));
        $this->assign("compName",$compName);
        $this->assign("check",1);
        $this->display("message_ac");
    }

    function ajaxmessage_ac(){
        //vName driverName cyzg dd zd hy corpName
        /*$c['totalNum'] = 0;
        $c['vname'] = I('vName')?I('vName'):'';//车牌号码
        $c['driverName'] = I('driverName')?I('driverName'):'';//姓名
        $c['corpName'] = I('corpName')?I('corpName'):'';//公司名称
        $c['cyzgz'] = I('cyzg')?I('cyzg'):'';//从业资格证
        $zfdwmc = I('dd');
        $zd = I('zd');
        $hy = I('hy');
        $startTime = I('startTime');
        $endTime = I('endTime');

        if($zfdwmc != '全部'){
            $c['zfdwmc'] = $zfdwmc;
        }else{
            $c['zfdwmc'] = '';
        }
        if($zd != '全部'){
            $c['zfry1'] = $zd;
        }else{
            $c['zfry1'] = '';
        }
        if($hy != '全部'){
            $c['hylb'] = $hy;
        }else{
            $c['hylb'] = '';
        }

        $c['startTime'] = strtotime($startTime);
        $c['endTime'] = strtotime($endTime);

        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;*/


        /*$R_json = json_encode($c);
        //{"totalNum":0,"vname":"","driverName":"","corpName":"","cyzgz":"","zfdwmc":"","zfry1":"","hylb":"","startTime":946656000,"endTime":1473231336,"startIndex":0,"endIndex":
        $R1_json =  postHttp(C("URL_BEFORE")."/requestApi/xinxi?type=queryRegisterInfoByName&jsonStr=".$R_json);
        $R1 = json_decode($R1_json,true);
        //echo C("URL_BEFORE")."/requestApi/xinxi?type=queryRegisterInfoByName&jsonStr=".$R_json;
        //var_dump($R1);
        $R['total'] = $R1[0]['totalNum'];
        $R['rows'] = mymArrsort($R1,'zfsj');
        $this->ajaxReturn ($R);*/
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
        $sort = I('sort');//排序字段
        $sortOrder = I('sortOrder');//排序方式
        // $c['zfzh'] = $_SESSION['admin']['name'];
        /*if($sort != ''){
            $c['sortOrder'] = $sort.'%20'.$sortOrder;
        }else{
            $c['sortOrder'] = 'ID%20'.$sortOrder;
        }*/

        //{"driverName":"白生志","cyzg":"267626","vName":"京BU1872","startTime":"1471366800","endTime":"1471446000","dd":"北京市交通执法总队首都机场执法大队","zd":"一中队","cz":"一车组","num":"123","corpName":"京东","startIndex":0,"endIndex":5}
        /*if($dd != '全部'){
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
        }*/


        if($driverName != ''){
            $c['driverName'] = $driverName;
        }else{
            $c['driverName'] = '';
        }
        if($cyzg != ''){
            $c['cyzgz'] = $cyzg;
        }else{
            $c['cyzgz'] = '';
        }
        if($vName != ''){
            $c['vname'] = $vName;
        }else{
            $c['vname'] = '';
        }
        /*if($num != ''){
            $c['num'] = $num;
        }else{
            $c['num'] = '';
        }*/
        if($corpName != ''){
            $c['corpName'] = $corpName;
        }else{
            $c['corpName'] = '';
        }


        $c['startTime'] = strtotime($startTime);
        $c['endTime'] = strtotime($endTime);

        $offset = I('offset');
        $maxrows = I('maxrows');
        $limit = I('limit');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;

        //2017-05-08
        $c['totalNum'] = 0;
        $c['hylb'] = '';
        $c['code'] = '';
        $c['cyzgz'] = '';
        $c['zfdwmc'] =I('dd');
        $c['zfry1'] = '';
        $c['status'] = '';
        $c['sszd'] = '';
        $c['sscz'] = '';
        $c['zfzh'] = $_SESSION['admin']['name'];

        $arr_json = json_encode($c);
        //$R_json = postHttp(C("URL_BEFORE")."/requestApi/xinxi?type=getRegisterInfoByName_Attach&jsonStr=".$arr_json);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/xinxi?type=getRegisterInfoByName&jsonStr=".$arr_json);
        //requestApi/xinxi?type=getRegisterInfoByName&jsonStr={"totalNum":0,"startIndex":0,"endIndex":10,"vname":null,"driverName":null,"corpName":null,"hylb":null,"code":null,"cyzgz":null,"zfdwmc":null,"startTime":"2649618","endTime":"1484464990","zfry1":null,"zfzh":"11131009","status":null,"sszd":null,"sscz":null}
        //10.212.160.180:9876/requestApi/xinxi?type=getRegisterInfoByName&jsonStr={"driverName":"","cyzgz":"","vname":"","corpName":"","startTime":1467302400,"endTime":1499070451,"startIndex":"0","endIndex":10,"totalNum":0,"hylb":"","code":"","zfdwmc":"","zfry1":"","status":"","sszd":"","sscz":"","zfzh":"0000000"}
        //echo C("URL_BEFORE")."/requestApi/xinxi?type=getRegisterInfoByName&jsonStr=".$arr_json;
        $R = json_decode($R_json,true);

        $Rz['rows'] = mymArrsort($R,'zfsj');
        $Rz['total'] = $R[0]['totalNum'];
        //p($R['rows']);
        $this->ajaxReturn ($Rz);
    }

    //执法记录查询结果页面
    public function message_ac_end(){
        $R['totalNum'] = 0;

        $R['vname'] = I('vName');
        $R['driverName'] = I('driverName') ;
        $R['corpName'] = I('corpName');
        $R['zfdwmc'] = I('zfdwmc');
        $startDate = I('startTime');
        $endDate = I('endTime');
        $R['startTime'] = strtotime($startDate);
        $R['endTime']   = strtotime($endDate);

        $page = I('page');
        if($page == '')
        {
            $page = 1;
        }
        $R['startIndex'] = ($page-1)*10+0;
        $R['endIndex'] = ($page-1)*10+10;
        //分页
        $R_json = json_encode($R);
        $url_b = C("URL_BEFORE");
        $url   = $url_b."/requestApi/xinxi?type=queryRegisterInfoByName&jsonStr=".$R_json;
       
        $R1_json =  postHttp($url);
        $R1 = json_decode($R1_json,true);
        $total  = $R1[0]['totalNum'];
        $times = ceil($total/10);
        $this->assign('page',$page);
        $this->assign('per',$page-1);
        $this->assign('next',$page+1);
        $this->assign('total',$total);
        $this->assign('times',$times);
        $this->assign('st',$startDate);
        $this->assign('en',$endDate);
        $this->assign('c',$R);
        $this->assign("R1",$R1);
        $this->assign("check",1);
        $this->display("message_ac_end");
    }
    //违法信息查询页面
    public function getMessageFalse(){
        $this->assign("check",1);
        $this->display('message_false');
    }
    //违法信息查询结果页面
    public function getMessageFalseEnd(){

        if(trim($_POST['hylb'])!='')
        {
            $data['hylb'] = $_POST['hylb'];
        }
        if(trim($_POST['vname'])!='')
        {
            $data['vname'] = $_POST['vname'];
        }
        if(trim($_POST['danshiren'])!='')
        {
            $data['danshiren'] = $_POST['danshiren'];
        }
        if(trim($_POST['jdkh'])!='')
        {
            $data['jdkh'] = $_POST['jdkh'];
        }
        if(trim($_POST['cropName'])!='')
        {
            $data['cropName'] = $_POST['cropName'];
        }
        $data['checkTime'] = 200812100817;//$RR->changeStartTime(I("checkTime"));
        $data['overTime']  = changeStartTime(I('endTime'));
        $data['startIndex'] = 0;
        $data['endIndex'] = 10;
        $data['totalNum'] = 0;
        $b_url = C("URL_BEFORE");
        $jsonStr = json_encode($data);
        $url    = $b_url."/requestApi/ShengJi?type=queryWeiFaInfo&jsonStr=".$jsonStr;
        $json   =  postHttp($url);
        $arr    = json_decode($json,true);
        $_SESSION['msg'] = $arr;
        $this->assign("json",$arr);
        $this->display('message_false_end');
    }
    //违法信息详情页面
    public function getMessageFalseEndDet(){
        $k = $_GET['k'];
        $R = $_SESSION['msg'][$k-1];
        $this->assign("R",$R);
        $this->assign("check",1);
        $this->display('message_false_end_det');
    }
    //投诉记录查询页面
    public function getMessageComplain(){
        $this->assign("check",1);
        $this->display('message_complain');
    }
    //投诉记录查询结果页面
    public function getMessageComplainEnd(){
        $this->assign("check",1);
        $this->display('message_complain_end');
    }


    //获取所有执法单位的名称
    function ajaxGetPersonnel(){
        $ht = I('ht');
        if($ht=='全部'){
            $data['ZFDWMC'] = 'all';
        }else{
            $data['ZFDWMC'] = $ht;
        }
        $jsonStr = json_encode($data);
        $url    = C("URL_BEFORE")."/requestApi/zfry?type=getGroup_Name&jsonStr=".$jsonStr;
        $json   =  postHttp($url);
        $json = json_decode(trim($json,chr(239).chr(187).chr(191)),true);
        $this->ajaxReturn ($json);
    }


    /**************/
    function PersonnelInfo(){
        $vname = I('vname');
        $zfsj = I('zfsj');
        $hylb = I('hylb');
        $data['vname'] = $vname;
        $data['zfsj'] = $zfsj;
        $data['hylb'] = $hylb;
        $jsonStr = json_encode($data);
        $url    = C("URL_BEFORE")."/requestApi/xinxi?type=get_Register_Info&jsonStr=".$jsonStr;
        $json   =  postHttp($url);
        $json = json_decode(trim($json,chr(239).chr(187).chr(191)),true);
        //p($json);
       /*  var_dump(date('Y-m-d H:i:s',1506528000));
        p( strtotime($json[0]['CREATE_TIME']));exit;*/
        $json[0]['CREATETIME'] = $json[0]['CREATETIME']/1000;
        $this->assign("check",1);
        $this->assign("json",$json[0]);
        $this->display('PersonnelInfo');
    }
    
}