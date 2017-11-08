<?php
namespace Home\Controller;
use Think\Controller;
class SystemController extends BestController {
    /**
     * 组织管理
     */
    public function Organization(){
    	$this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );

        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);

        $this->assign("check",6);
        $this->display("Organization");
    }
    function ajaxOrganization(){
        $dd = I('dd');//大队
        $hy = I('hy');//中队


        if($dd != '全部'){
            $c['dd'] = $dd;
        }else{
            $c['dd'] = '';
        }
        if($hy != '全部'){
            $c['hy'] = $hy;
        }else{
            $c['hy'] = '';
        }

        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=Organization&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 组织管理(add)
     */
    function addOrganization(){

    }
    function ajaxaddOrganization(){

    }
    


    /*************************/

    /**
     * 用户管理
     */
    function UserList(){
        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);

        $this->assign("check",6);
        $this->display("UserList");
    }
    function ajaxUserList(){
        $zfzh = I("zfzh");
        $name = I("name");
        $sex = I("sex");
        $dd = I("dd");

        $c['zfzh'] = $zfzh?$zfzh:'';
        $c['name'] = $name?$name:'';
        if($sex != '全部'){
            $c['sex'] = $sex;
        }else{
            $c['sex'] = '';
        }
        if($dd != '全部'){
            $c['dd'] = $dd;
        }else{
            $c['dd'] = '';
        }

        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;
        //{"zfzh":"0000000","name":"貂蝉","sex":"女","dd":"北京市交通执法总队第五执法大队","startIndex":0,"endIndex":5}

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=UserList&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        //p($R_json);
    //echo C("URL_BEFORE")."/requestApi/bs_Taxi?type=UserList&jsonStr=".$arr_json;
        $this->ajaxReturn ($R);
    }
    /**
     * 用户管理(状态)
     */
    function changeUserStatus(){
        $id = I("id");
        $Status = I("Status");

        $c['id'] = $id;
        $c['Status'] = $Status;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=changeUserStatus&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);

    }
    /**
     * 用户管理(add)
     */
    function addUser(){

        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);

        //权限
        $c1['ZFZH'] = $_SESSION['admin']['name'];
        $arr_json1 = json_encode($c1);
        $R_json1 = postHttp(C("URL_BEFORE")."/requestApi/permission?type=query_Next_Role&jsonStr=".$arr_json1);
        $R1 = json_decode($R_json1,true);
        $this->assign("R1",$R1);

        $this->assign("check",6);
        $this->display("addUser");
    }
    function ajaxaddUser(){
        //requestApi/bs_Taxi?type=addUser&jsonStr={"zfzh":"1111112","name":"貂蝉姐","sex":"女","zfdwmc":"北京市交通执法总队第五执法大队","role_id":"4","pwd":"123","sszd":"二中隊","sscz":"二車組","phone":"12112111211","sjssdwmc":"交委"}  
        //账号,姓名,性别,组织
        $zfzh = I("zfzh");//账号
        $name = I("name");//姓名
        $sex = I("sex");//性别
        $zfdwmc = I("zfdwmc");//组织
        $role_id = I("role_id");
        $pwd = I("pwd");
        $sszd = I("sszd");
        $sscz = I("sscz");
        $phone = I("phone");
        $sjssdwmc = I("sjssdwmc");
        //$phone = I("phone");
        //$sjssdwmc = I("sjssdwmc");

        $c['zfzh'] = $zfzh;
        $c['name'] = $name;
        if($sex != '全部'){
            $c['sex'] = $sex;
        }else{
            $c['sex'] = '';
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

        $c['role_id'] = $role_id;
        $c['pwd'] = $pwd;
        $c['phone'] = $phone;
        $c['sjssdwmc'] = $sjssdwmc;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=addUser&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);

    }
    /**
     * 用户管理(edit)
     */
    function editUser(){
        
        $zfzh = I("zfzh");

        $c['zfzh'] = $zfzh;
       
        //requestApi/bs_Taxi?type=UserAllList&jsonStr={"zfzh":"0000000","name":"貂蝉","sex":"女","dd":"北京市交通执法总队第五执法大队"}
        //大队
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=viewUser&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        //p($R);
        //权限
        $c1['ZFZH'] = $_SESSION['admin']['name'];
        $arr_json1 = json_encode($c1);
        $R_json1 = postHttp(C("URL_BEFORE")."/requestApi/permission?type=query_Next_Role&jsonStr=".$arr_json1);
        $R1 = json_decode($R_json1,true);
        $this->assign("R1",$R1);
        //p($R1);
//  
        /*$R['rows'][0]['SSZD'] = '';
        $R['rows'][0]['SSCZ'] = '';*/
        //wp($R['rows'][0]);
        $this->assign("R",$R['rows'][0]);

        $compName =  getCompName();
        $this->assign("compName",$compName);

        $this->assign("check",6);
        $this->display("editUser");
    }
    function ajaxeditUser(){
        //{"zfzh":"1111112","name":"貂蝉妹妹","sex":"女","zfdwmc":"北京市交通执法总队第五执法大队","pwd":"1234","sszd":"二中队","sscz":"二车組","phone":"12112111211","feedback":"121"} 
        //账号,姓名,性别,组织
        $zfzh = I("zfzh");//账号
        $name = I("name");//姓名
        $sex = I("sex");//性别
        $zfdwmc = I("zfdwmc");//组织
        //$role_id = I("role_id");
        $pwd = I("pwd");
        $sszd = I("sszd");
        $sscz = I("sscz");
        $phone = I("phone");
        $sjssdwmc = I("sjssdwmc");
        $phone = I("phone");
        $feedback = I("feedback");
        //$sjssdwmc = I("sjssdwmc");

        $c['zfzh'] = $zfzh;
        $c['name'] = $name;
        if($sex != '全部'){
            $c['sex'] = $sex;
        }else{
            $c['sex'] = '';
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

        //$c['role_id'] = $role_id;
        $c['pwd'] = $pwd;
        $c['phone'] = $phone;
        $c['sjssdwmc'] = $sjssdwmc;
        $c['feedback'] = $feedback;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=editUser&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);

    }
    /**
     * 用户管理(del)
     */
    function delUser(){
        $id = I("id");

        $c['id'] = $id;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=delUser&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }

    /**
     * 角色分类
     */
    function roleStyle(){
        $this->assign("check",6);
        $this->display("roleStyle");
    }
    function ajaxroleStyle(){
        /*3.返回下级所有角色id和名称
        /requestApi/permission?type=query_Next_Role&jsonStr={“ZFZH”:””}*/
        /*$offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows;*/
        $c['ZFZH'] = $_SESSION['admin']['name'];
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/permission?type=query_Next_Role&jsonStr=".$arr_json);
        
        $R = json_decode($R_json,true);
        $res['total'] =count($R);
        $res['rows'] = $R;
        $this->ajaxReturn ($res);
    }

    /**
     * 角色分类(add)
     */
    function addRoleStyle(){
        $this->assign("check",6);
        $this->display("addRoleStyle");
    }
    function ajaxaddRoleStyle(){
        $rolename = I('rolename');
        $desc = I('desc');
        $c['rolename'] = $rolename;
        $c['desc'] = $desc;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=addRoleStyle&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 角色分类(edit)
     */
    function editRoleStyle(){
        $id = I('id');
        $rolename = I('rolename');
        $desc = I('desc');

        $this->assign("id",$id);
        $this->assign("rolename",$rolename);
        $this->assign("desc",$desc);
        $this->assign("check",6);
        $this->display("editRoleStyle");
    }
    function ajaxeditRoleStyle(){
        $id = I('id');
        $rolename = I('rolename');
        $desc = I('desc');

        $c['id'] = $id;
        $c['rolename'] = $rolename;
        $c['desc'] = $desc;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=editRoleStyle&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 角色分类(del)
     */
    function delRoleStyle(){

    }
    /**
     * 角色设置
     */
    function roleSet(){
        $this->assign("check",6);
        $this->display("roleSet");
    }
    function ajax(){
        $c['ZFZH'] = $_SESSION['admin']['name'];
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/permission?type=query_Next_Role&jsonStr=".$arr_json);
        
        $R = json_decode($R_json,true);
        $res['total'] =count($R);
        $res['rows'] = $R;
        $this->ajaxReturn ($res);
    }
    /**
     * 角色设置(add)
     */
    function addRoleSet(){
        $this->assign("check",6);
        $this->display("addRoleSet");
    }
    /**
     * 角色设置(edit)
     */
    function editRoleSet(){

    }
    /**
     * 角色设置(del)
     */
    function delRoleSet(){

    }
    /**
     * 权限管理(手机端)
     */
    function permissions(){
        
        $this->assign("check",6);
        $this->display("permissions");
    }
    function ajaxpermissions(){
        //requestApi/permission?type=queryPermission&jsonStr={"ZFZH":""}
        $c['ZFZH'] = $_SESSION['admin']['name'];
        //123.57.236.212:8080/requestApi/bs_Taxi?type=editRoleStyle&jsonStr={ZFZH:"administrator"}
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/permission?type=queryPermission&jsonStr=".$arr_json);
        
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 权限管理(电脑端)
     */
    function permissionsPC(){
        $this->assign("check",6);
        $this->display("permissionsPC");
    }
    /**
     * 日志管理
     */
    function logList(){
        $this->assign("check",6);
        $this->display("logList");
    }
    /**
     * 日志管理(del)
     */
    function delLog(){

    }
    /**
     * APP端系统公告维护
     */
    function AppNotice(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );
        $this->assign("check",6);
        $this->display("AppNotice");
    }
    function ajaxAppNotice(){
        //requestApi/bs_Taxi?type=AppNotice&jsonStr={"BT":"","STATUS":"","RELEASE_TIME":"","END_TIME":"","RELEASE_PERSON":"","RELEASE_GROUP":"","startIndex":"","endIndex":""}
        //发布起始时间,结束时间,标题,发布人,组织,是否开启
        $BT = I('title');//标题
        $STATUS = I('status');//
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间
        $RELEASE_PERSON = I('person');//
        $RELEASE_GROUP = I('group');//

        $c['BT'] = $BT;
        $c['STATUS'] = $STATUS;
        $c['RELEASE_TIME'] = strtotime($startTime);
        $c['END_TIME'] = strtotime($endTime);

        $c['RELEASE_PERSON'] = $RELEASE_PERSON;
        $c['RELEASE_GROUP'] = $RELEASE_GROUP;

        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=AppNotice&jsonStr=".$arr_json);
        //echo C("URL_BEFORE")."/requestApi/bs_Taxi?type=AppNotice&jsonStr=".$arr_json;
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * APP端系统公告维护(add)
     */
    function addAppNotice(){
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );
        $this->assign("check",6);
        $this->display("addAppNotice");
    }
    function ajaxaddAppNotice(){
        //bs_Taxi?type=addAppNotice&jsonStr={"BT":"信息","RELEASE_PERSON":"貂蝉","RELEASE_GROUP":"三国","STATUS":"1","RELEASE_TIME":"1471700000","END_TIME":"1472549599"}
        
        /*$image = $_FILES["file"]["tmp_name"];
        $fp = fopen($image, "r");
        $file = fread($fp, $_FILES["file"]["size"]); //二进制数据流
        $data=base64_encode($file);//用base64对字符串编码
        $filename = '1.jpg';
        $Ts=fopen($filename,"a+");
        fwrite($Ts,$file); //写入二进制流到文件
        fclose($Ts); //关闭文件*/


        /*$image = $_FILES["file"]["tmp_name"];
        $fp = fopen($image, "r");
        $file = fread($fp, $_FILES["file"]["size"]); //二进制数据流
        $data=base64_encode($file);//用base64对字符串编码
        $filename = '1.txt';
        $Ts=fopen($filename,"a+");
        fwrite($Ts,$data); //写入二进制流到文件
        fclose($Ts); //关闭文件*/


        /*if ($_FILES ['file'] ['error'] == UPLOAD_ERR_OK) {
                $dir = "Upload/App/" . date ( 'Ymd' );
            if (! is_dir ( $dir )) {
                mkdir ($dir,0777,ture );
            }
            $key = $dir . "/" . uniqid ().substr($_FILES ['file']['name'],strpos($_FILES ['file']['name'],"."));
            move_uploaded_file ( $_FILES ['file'] ['tmp_name'], $key );
        }*/

        //123.57.236.212:8080/requestApi/bs_Taxi?type=addAppNotice&jsonStr={"BT":"信息","RELEASE_PERSON":"貂蝉","RELEASE_GROUP":"三国","STATUS":"1","RELEASE_TIME":"1471700000","END_TIME":"1472549599"}
        //123.57.236.212:8080/requestApi/bs_Taxi?type=addAppNotice&jsonStr={"BT":"22","STATUS":"1","RELEASE_TIME":1469980800,"END_TIME":1472745599,"RELEASE_PERSON":"33","RELEASE_GROUP":"44"}

        $BT = I('title');//标题
        $STATUS = I('status');//
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间
        $RELEASE_PERSON = I('person');//
        $RELEASE_GROUP = I('group');//

        $c['BT'] = $BT;
        $c['STATUS'] = $STATUS;
        $c['RELEASE_TIME'] = strtotime($startTime);
        $c['END_TIME'] = strtotime($endTime);
        $c['RELEASE_PERSON'] = $RELEASE_PERSON;
        $c['RELEASE_GROUP'] = $RELEASE_GROUP;

        /*$c['startIndex'] = 0;
        $c['endIndex'] = 5;*/

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=addAppNotice&jsonStr=".$arr_json);

        //echo C("URL_BEFORE")."/requestApi/bs_Taxi?type=addAppNotice&jsonStr=".$arr_json;
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);

    }
    /**
     * APP端系统公告维护(change)开启与否
     */
    function changeAppNotice(){
        //requestApi/bs_Taxi?type=changeAppNotice&jsonStr={"id":"","status":""}
        $id = I("id");
        $status = I("status");

        $c['id'] = $id;
        $c['status'] = $status;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=changeAppNotice&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }
    /**
     * APP端系统公告维护(del)
     */
    function delAppNotice(){
        //requestApi/bs_Taxi?type=delAppNotice&jsonStr={"id":""}
        $id = I("id");

        $c['id'] = $id;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=delAppNotice&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }
    /**
     * 检查项维护
     */
    function checkMaintain(){
        $this->assign("check",6);
        $this->display("checkMaintain");
    }
    function ajaxcheckMaintain(){
        //requestApi/bs_Taxi?type=checkMaintain&jsonStr={"hylb":"113","bjczt":"貂蝉吗","jclb":"女","bm":"北京市","jcjg":"123","startIndex":0,"endIndex":5}
        //行业,被检查主体,代码,检查类别,检查结果
        $hylb = I('hylb');//行业
        $bjczt = I('bjczt');//被检查主体
        $jclb = I('jclb');//检查类别
        $bm = I('bm');//代码
        $jcjg = I('jcjg');//检查结果

        if($hylb != '全部'){
            $c['hylb'] = $hylb;
        }else{
            $c['hylb'] = '';
        }
        $c['bjczt'] = $bjczt;
        $c['jclb'] = $jclb;
        $c['bm'] = $bm;
        $c['jcjg'] = $jcjg;


        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=checkMaintain&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 检查项维护(add)
     */
    function addcheckMaintain(){
        $this->assign("check",6);
        $this->display("addcheckMaintain");
    }
    function ajaxaddcheckMaintain(){
        //requestApi/bs_Taxi?type=addcheckMaintain&jsonStr={"HYLB":"112","BJCZT":"貂蝉姐","JCLB":"女","BM":"北京市","BH":"4","JCJG":"123","WFXW":"二中隊","WFYJ":"二車組","YJTK":"12","CFTK":"交委","FGGD":"交委"}

        $HYLB = I('HYLB');//行业
        $BJCZT = I('BJCZT');//被检查主体
        $JCLB = I('JCLB');//检查类别
        $BM = I('BM');//代码
        $BH = I('BH');//
        $JCJG = I('JCJG');//检查结果
        $WFXW = I('WFXW');//
        $WFYJ = I('WFYJ');//
        $YJTK = I('YJTK');//
        $CFTK = I('CFTK');//
        $FGGD = I('FGGD');//

        if($HYLB != '全部'){
            $c['HYLB'] = $HYLB;
        }else{
            $c['HYLB'] = '';
        }
        $c['ID'] = $ID;
        $c['BJCZT'] = $BJCZT;
        $c['JCLB'] = $JCLB;
        $c['BM'] = $BM;
        $c['BH'] = $BH;
        $c['JCJG'] = $JCJG;
        $c['WFXW'] = $WFXW;
        $c['WFYJ'] = $WFYJ;
        $c['YJTK'] = $YJTK;
        $c['CFTK'] = $CFTK;
        $c['FGGD'] = $FGGD;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=addcheckMaintain&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 检查项维护(edit)
     */
    function editcheckMaintain(){
        $id = I('id');//代码 
        $c['id'] = $id; 

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=viewcheckMaintain&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        /*echo C("URL_BEFORE")."/requestApi/bs_Taxi?type=viewcheckMaintain&jsonStr=".$arr_json;
        p($R['rows'][0]);*/
        $this->assign("R",$R['rows'][0]);
        $this->assign("check",6);
        $this->display("editcheckMaintain");
    }
    function ajaxeditcheckMaintain(){
        //requestApi/bs_Taxi?type=editcheckMaintain&jsonStr={"ID":"3a72d5d69aae460ca5aa6954a5e33d0e","HYLB":"113","BJCZT":"貂蝉吗","JCLB":"女","BM":"北京市","BH":"4","JCJG":"123","WFXW":"二中隊","WFYJ":"二車組","YJTK":"12","CFTK":"交委","FGGD":"交委"}
        $ID = I('ID');//行业
        $HYLB = I('HYLB');//行业
        $BJCZT = I('BJCZT');//被检查主体
        $JCLB = I('JCLB');//检查类别
        $BM = I('BM');//代码
        $BH = I('BH');//
        $JCJG = I('JCJG');//检查结果
        $WFXW = I('WFXW');//
        $WFYJ = I('WFYJ');//
        $YJTK = I('YJTK');//
        $CFTK = I('CFTK');//
        $FGGD = I('FGGD');//

        if($HYLB != '全部'){
            $c['HYLB'] = $HYLB;
        }else{
            $c['HYLB'] = '';
        }
        $c['ID'] = $ID;
        $c['BJCZT'] = $BJCZT;
        $c['JCLB'] = $JCLB;
        $c['BM'] = $BM;
        $c['BH'] = $BH;
        $c['JCJG'] = $JCJG;
        $c['WFXW'] = $WFXW;
        $c['WFYJ'] = $WFYJ;
        $c['YJTK'] = $YJTK;
        $c['CFTK'] = $CFTK;
        $c['FGGD'] = $FGGD;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=editcheckMaintain&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 检查项维护(del)
     */
    function delcheckMaintain(){
        //requestApi/bs_Taxi?type=delcheckMaintain&jsonStr={"id":""}
        $id = I("id");

        $c['id'] = $id;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=delcheckMaintain&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }
    /**
     * 移动摄像头维护
     */
    function mobileCameraMaintain(){
        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);

        $this->assign("check",6);
        $this->display("mobileCameraMaintain");
    }
    function ajaxmobileCameraMaintain(){
        //requestApi/bs_Taxi?type=mobileCameraMaintain&jsonStr={"SUDD":"北京市交通执法总队第五执法大队","CAMERA_NAME":"鹰眼1号","SN_CODE":"666666666","HOND_HAND":"11130511","startIndex":0,"endIndex":5}
        //所属大队,摄像头名称,SN码,已绑定手持端
        $SUDD = I('dd');//所属大队
        $CAMERA_NAME = I('name');//摄像头名称
        $SN_CODE = I('sn_code');//SN码
        $HOND_HAND = I('hand');//已绑定手持端

        if($SUDD != '全部'){
            $c['SUDD'] = $SUDD;
        }else{
            $c['SUDD'] = '';
        }
        $c['CAMERA_NAME'] = $CAMERA_NAME;
        $c['SN_CODE'] = $SN_CODE;
        $c['HOND_HAND'] = $HOND_HAND;


        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=mobileCameraMaintain&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 移动摄像头维护(add)
     */
    function addmobileCameraMaintain(){
        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);
        
        $this->assign("check",6);
        $this->display("addmobileCameraMaintain");
    }
    function ajaxaddmobileCameraMaintain(){
        //requestApi/bs_Taxi?type=addmobileCameraMaintain&jsonStr={"SUDD":"北京市交通执法总队第五执法大队","CAMERA_NAME":"鹰眼1号","SN_CODE":"666666666","HOND_HAND":"11130511"}
        $SUDD = I('dd');//所属大队
        $CAMERA_NAME = I('name');//摄像头名称
        $SN_CODE = I('sn_code');//SN码
        $HOND_HAND = I('hand');//已绑定手持端
    
        $c['SUDD'] = $SUDD;
        $c['CAMERA_NAME'] = $CAMERA_NAME;
        $c['SN_CODE'] = $SN_CODE;
        $c['HOND_HAND'] = $HOND_HAND;


        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=addmobileCameraMaintain&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 移动摄像头维护(edit)
     */
    function editmobileCameraMaintain(){
        //requestApi/bs_Taxi?type=viewmobileCameraMaintain&jsonStr={"id":"2026656d159642ca9d4b52835bde75fb"}
        $id = I('id');//代码 
        $c['id'] = $id; 

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=viewmobileCameraMaintain&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        //p($R);

        $this->assign("R",$R['rows'][0]);

        $this->assign("id",$id);
        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);
        
        $this->assign("check",6);
        $this->display("editmobileCameraMaintain");
    }
    function ajaxeditmobileCameraMaintain(){
        //requestApi/bs_Taxi?type=editmobileCameraMaintain&jsonStr={"SUDD":"北京市交通执法总队第五执法大队","CAMERA_NAME":"鹰眼2号","SN_CODE":"666666999","HOND_HAND":"11130511","ID":"2026656d159642ca9d4b52835bde75fb"}
        $ID = I('id');
        $SUDD = I('dd');//所属大队
        $CAMERA_NAME = I('name');//摄像头名称
        $SN_CODE = I('sn_code');//SN码
        $HOND_HAND = I('hand');//已绑定手持端
        
        $c['ID'] = $ID;
        $c['SUDD'] = $SUDD;
        $c['CAMERA_NAME'] = $CAMERA_NAME;
        $c['SN_CODE'] = $SN_CODE;
        $c['HOND_HAND'] = $HOND_HAND;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=editmobileCameraMaintain&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 移动摄像头维护(del)
     */
    function delmobileCameraMaintain(){
        //requestApi/bs_Taxi?type=delmobileCameraMaintain&jsonStr={"id":"2026656d159642ca9d4b52835bde75fb"}
        $id = I("id");
        $c['id'] = $id;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=delmobileCameraMaintain&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }

        
    /**
     * 登录访问统计
     */
    function loginAccess(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60)) );

        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);

        $this->assign("check",6);
        $this->display("loginAccess");
    }
    /**
     * 登录访问统计
     */
    function ajaxloginAccess(){

        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间

        $c['startTime'] = strtotime($startTime);
        $c['endTime'] = strtotime($endTime);
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=queryCount_Number&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        //p($R);
        $Res['rows'][0]['login_count'] = $R['login_count'][0]['LOGINCOUNT'];
        $Res['rows'][0]['interface_count'] = $R['interface_count'][0]['INTERFACECOUNT'];
        $Res['total'] = 1;
        $this->ajaxReturn ($Res);
    }
    
    
   
}