<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/18
 * Time: 15:25
 */

namespace Home\Controller;


use Home\Model\LoginModel;

class AdminController extends BestController
{
    //管理员管理 用户管理
    public function index(){
         
        $compName = getCompName();
        //$compName = json_decode($compName);
        // print_r($compName);
        $this->assign("compName",$compName);
        $this->assign("check",6);
       /* if(IS_POST||(IS_GET && I('sim'))){*/
            $sim = I('sim')?I('sim'):'查询用户';
            $page = I('page')?I('page'):'';
            if($page == '')
            {
                $page =1;
            }
            $c['startIndex'] = ($page-1)*10+0;
            $c['endIndex'] = ($page-1)*10+10;
            $c['ZFZH'] = I('ZFZH')?I('ZFZH'):'';
            $c['NAME'] = I('name')?I('name'):'';
            $c['ZFDWMC'] = I('dd')?I('dd'):'';
            if((I('zd')?I('zd'):'') == '--请选择--'){
                $c['SSZD'] = '';
            }else{
                $c['SSZD'] = I('zd');
            }
            if((I('cz')?I('cz'):'') == '--请选择--'){
                $c['SSCZ'] = '';
            }else{
                $c['SSCZ'] = I('cz');
            }
            $c['SIM_CODE'] = '';
            $c['IMEI_CODE'] = '';

            $c1 = $c;
            $c1['sim']= $sim;
            $R = json_encode($c);
             
            $b_url = C('URL_BEFORE');
            $a_url = '/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr='.$R;
           //echo $url = $b_url.$a_url;
            $RR =  postHttp($url);
            $R = json_decode($RR,true);
            //p($R);
            //分页
            $total  = $R[0]['totalNum'];
            $times = ceil($total/10);
            $this->assign('page',$page);
            $this->assign('per',$page-1);
            $this->assign('next',$page+1);
            $this->assign('total',$total);
            $this->assign('times',$times);
            //分页完
            $this->assign('c',$c1);
            $this->assign('R',$R);
            $this->assign("check",6);

            $this->assign('sim',$sim);
            $this->assign('ZFZH', I('ZFZH'));
            $this->assign('name', I('name'));
            $this->assign('dd', I('dd')?I('dd'):'--请选择--');
            $this->assign('zd', I('zd')? I('zd'):'--请选择--');
            $this->assign('cz', I('cz')?I('cz'):'--请选择--');

           

            if($sim == '删除用户')
            {   
                //$this->display('index_user_end');
                
                if($total){
                    $this->assign('show','index_user_end');
                }else{
                    $this->assign('errormsg','暂无数据');
                }
            }
            if($sim == '禁用账户')
            {   
                
                if($total){
                   $this->assign('show','index_jy_end');
                }else{
                    $this->assign('errormsg','暂无数据');
                }
                //$this->display('index_jy_end');
            }
            if($sim == '查询用户')
            {   
               
                 if($total){
                    $this->assign('show','index_user_se_end');
                }else{
                    $this->assign('errormsg','暂无数据');
                }
                /*$this->assign('html','index_user_end');*/
                //$this->display('index_user_end');
            }
            if($sim == '最后登录')
            {   
                if($total){
                    $this->assign('show','index_login_end');
                }else{
                    $this->assign('errormsg','暂无数据');
                }
                
                //$this->display('index_login_end');
            }

        /*}else{
            $this->assign('sim','删除用户');
            $this->assign('dd', '--请选择--');
            $this->assign('zd', '--请选择--');
            $this->assign('cz', '--请选择--');
        }*/
        $this->display("index");
    }
    //用户信息
    function pp_info(){
        $c['startIndex'] =+0;
        $c['endIndex'] = 10;
        $c['ZFZH'] = I('zfzh');
        $c['NAME'] = '';
        $c['ZFDWMC'] = '';
        $c['SIM_CODE'] ='';
        $c['IMEI_CODE'] = '';
        $c['SSZD'] = '';
        $c['SSCZ'] = '';
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $R = json_decode($RR,true);
        //p($R);
        $RC = $R[0];
        $this->assign("check",6);
        $this->assign('R',$RC);
        $this->display('person_info');

    }

    //个人信息
    public function person_info(){
        $this->assign("check",6);
        $this->display("person_info");
    }
    //用户查询结果界面
    public function index_user_end(){
        $sim = I('sim');
        $page = I('page');
        if($page == '')
        {
            $page =1;
        }
        $c['startIndex'] = ($page-1)*10+0;
        $c['endIndex'] = ($page-1)*10+10;
        $c['ZFZH'] = I('ZFZH');
        $c['NAME'] = I('name');
        $c['ZFDWMC'] = I('dd');
        $c['SIM_CODE'] = '';
        $c['IMEI_CODE'] = '';

        $c1 = $c;
        $c1['sim']= $sim;
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $R = json_decode($RR,true);
        //分页
        $total  = $R[0]['totalNum'];
        $times = ceil($total/10);
        $this->assign('page',$page);
        $this->assign('per',$page-1);
        $this->assign('next',$page+1);
        $this->assign('total',$total);
        $this->assign('times',$times);
        //分页完
        $this->assign('c',$c1);
        $this->assign('R',$R);
        $this->assign("check",6);
        if($sim == '删除用户')
        {
            $this->display('index_user_end');
        }
        if($sim == '禁用账户')
        {
            $this->display('index_jy_end');
        }
        if($sim == '查询用户')
        {
            $this->display('index_user_end');
        }
        if($sim == '最后登录')
        {
            $this->display('index_login_end');
        }
    }
    /*用户绑定角色*/
    function userRole(){
        /*查询所有角色*/
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryRole");
        $R = json_decode($R_json,true);
        $this->assign("R",$R);
        /*查询已绑定的角色*/
        $zfzh = I("zfzh");

        $c['zfzh'] = $zfzh;

        $arr_json1 = json_encode($c);
        $R_json1 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=getRoleByZfzh&jsonStr=".$arr_json1);
        $R1 = json_decode($R_json1,true);
        foreach ($R1 as $val){
            $R2[]=$val['ID'];
        }
        // p($R2);
        $this->assign("R2",$R2);
        $this->assign("zfzh",$zfzh);
        $this->assign("check",6);
        $this->display("userRole");
    }
    function ajaxUserRole(){
        $zfzh = I("zfzh");
        $role_id = I("role_id");
        /*查询用户是否绑定角色*/
        $c2['zfzh'] = $zfzh;
        $c3['id'] = $zfzh;
        $c3['role_id'] = $role_id;
        $arr_json3 = json_encode($c2);
        $R_json3 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=getRoleByZfzh&jsonStr=".$arr_json3);
        $R3 = json_decode($R_json3,true);
        if (!empty($R3)){
            //$this->ajaxReturn('您已经添加过角色了，如要修改，请先解除！');
            $arr_json5 = json_encode($c3);
            $R_json5 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=updateUser_Role&jsonStr=".$arr_json5);
            $R5 = json_decode($R_json5,true);
            $this->ajaxReturn($R5);
        }else{
            /*绑定角色*/
            $c['zfzh'] = $zfzh;
            $c['role_id'] = $role_id;
            $arr_json1 = json_encode($c);
            $R_json1 = postHttp(C("URL_BEFORE") . "/requestApi/Powers?type=setUser_Role&jsonStr=" . $arr_json1);
            $R1 = json_decode($R_json1, true);
            $this->ajaxReturn($R1);
        }
    }
    /*解除绑定*/
    function delRole(){
        $zfzh = I("zfzh");
        $c['id'] = $zfzh;
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=delUser_Role&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    //simka管理页面
    public function index_sim(){

        $compName = getCompName();
        //$compName = json_decode($compName);
        // print_r($compName);
        $this->assign("compName",$compName);
        $this->assign("check",6);
         
        /*if(IS_POST||(IS_GET && I('sim'))){*/
            $sim = I('sim')?I('sim'):'查看SIM';
            $page = I('page')?I('page'):'';
            if($page == '')
            {
                $page =1;
            }
            $c['startIndex'] = ($page-1)*10+0;
            $c['endIndex'] = ($page-1)*10+10;
            $c['ZFZH'] = I('ZFZH')?I('ZFZH'):'';
            $c['NAME'] = I('name')?I('name'):'';
            $c['ZFDWMC'] = I('dd')?I('dd'):'';
            if((I('zd')?I('zd'):'') == '--请选择--'){
                $c['SSZD'] = '';
            }else{
                $c['SSZD'] = I('zd');
            }
            if((I('cz')?I('cz'):'') == '--请选择--'){
                $c['SSCZ'] = '';
            }else{
                $c['SSCZ'] = I('cz');
            }
            $c['SIM_CODE'] =I('sim_code')?I('sim_code'):'';
            $c['IMEI_CODE'] = '';
            $c1 = $c;
            $c1['sim']= $sim;
            $R = json_encode($c);
             
            $b_url = C('URL_BEFORE');
            $a_url = '/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr='.$R;
            $url = $b_url.$a_url;
            $RR =  postHttp($url);
            $R = json_decode($RR,true);
            //p($R);
            //分页
            $total  = $R[0]['totalNum'];
            $times = ceil($total/10);
            $this->assign('page',$page);
            $this->assign('per',$page-1);
            $this->assign('next',$page+1);
            $this->assign('total',$total);
            $this->assign('times',$times);
            //分页完
            $this->assign('c',$c1);
            $this->assign('R',$R);
            $this->assign("check",6);

            $this->assign('sim',$sim);
            $this->assign('ZFZH', I('ZFZH')?I('ZFZH'):'');
            $this->assign('name', I('name')?I('name'):'');
            $this->assign('sim_code', I('sim_code')?I('sim_code'):'');
            /*$this->assign('dd', I('dd'));
            $this->assign('zd', I('zd'));
            $this->assign('cz', I('cz'));*/
            $this->assign('dd', I('dd')?I('dd'):'--请选择--');
            $this->assign('zd', I('zd')? I('zd'):'--请选择--');
            $this->assign('cz', I('cz')?I('cz'):'--请选择--');

            if($sim == '删除SIM')
            {
                //$this->display('index_sim_end');
                if($total){
                    $this->assign('show','index_sim_end');
                }else{
                    $this->assign('errormsg','暂无数据');
                }
               
            }
            if($sim == '修改SIM')
            {
                //$this->display('index_sim_jy_end');
                
                if($total){
                    $this->assign('show','index_sim_jy_end');
                }else{
                    $this->assign('errormsg','暂无数据');
                }
            }
            if($sim == '查看SIM')
            {
                //$this->display('index_sim_se_end');
               
                if($total){
                     $this->assign('show','index_sim_se_end');
                }else{
                    $this->assign('errormsg','暂无数据');
                }
            }
       /* }else{
            $this->assign('sim','删除SIM');
            $this->assign('dd', '--请选择--');
            $this->assign('zd', '--请选择--');
            $this->assign('cz', '--请选择--');
        }*/
        
        $this->display('index_sim');
    }
    //sim查询结果
    public function index_sim_end(){
        $sim = I('sim');
        $page = I('page');
        if($page == '')
        {
            $page =1;
        }
        $c['startIndex'] = ($page-1)*10+0;
        $c['endIndex'] = ($page-1)*10+10;
        $c['ZFZH'] = I('ZFZH');
        $c['NAME'] = I('name');
        $c['ZFDWMC'] = I('dd');
        $c['SIM_CODE'] =I('sim_code');
        $c['IMEI_CODE'] = '';
        $c1 = $c;
        $c1['sim']= $sim;
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $R = json_decode($RR,true);
        //分页
        $total  = $R[0]['totalNum'];
        $times = ceil($total/10);
        $this->assign('page',$page);
        $this->assign('per',$page-1);
        $this->assign('next',$page+1);
        $this->assign('total',$total);
        $this->assign('times',$times);
        //分页完
        $this->assign('c',$c1);
        $this->assign('R',$R);
        $this->assign("check",6);
        if($sim == '删除SIM')
        {
            $this->display('index_sim_end');
        }
        if($sim == '修改SIM')
        {
            $this->display('index_sim_jy_end');
        }
        if($sim == '查看SIM')
        {
            $this->display('index_sim_se_end');
        }
    }
    //修改sim卡
    public function index_sim_update(){
        $zfzh  = I('zfzh');
        $this->assign("zfzh",$zfzh);
        $this->assign("check",6);
        //$this->display('index_sim_update');
        $this->display('Admin_sim_Edit');
    }
    //ajax修改sim
    function ajaxUpdateSim(){
        $c['NEW_SIM_CODE'] =I('n_sim');
        $c['SIM_CODE'] =I('old_sim');
        $c['ZFZH'] =I('zfzh');
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=update_Zfry_SimCode&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $CC = json_decode($RR,true);
        $this->ajaxReturn($CC);
    }

    //查看资料
    function toSelectSim(){
        $c['startIndex'] =+0;
        $c['endIndex'] = 10;
        $c['ZFZH'] = I('zfzh');
        $c['NAME'] = '';
        $c['ZFDWMC'] = '';
        $c['SIM_CODE'] ='';
        $c['IMEI_CODE'] = '';
        $c['SSZD'] = '';
        $c['SSCZ'] = '';
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $R = json_decode($RR,true);
        $RC = $R[0];
        //p($R);
        $this->assign("check",6);
        $this->assign('R',$RC);
        //$this->display('s_info');
        $this->display('Admin_sim_info');

    }


    //PDA卡
    public function index_pda(){
         
        $compName = getCompName();
        //$compName = json_decode($compName);
        // print_r($compName);
        $this->assign("compName",$compName);
        $this->assign("check",6);
        /*if(IS_POST||(IS_GET && I('sim'))){*/
             $sim = I('sim')?I('sim'):'查看PDA';
            $page = I('page')?I('page'):'';
            if($page == '')
            {
                $page =1;
            }
            $c['startIndex'] = ($page-1)*10+0;
            $c['endIndex'] = ($page-1)*10+10;
            $c['ZFZH'] = I('ZFZH')?I('ZFZH'):'';
            $c['NAME'] = I('name')?I('name'):'';
            $c['ZFDWMC'] = I('dd')?I('dd'):'';
            if((I('zd')?I('zd'):'') == '--请选择--'){
                $c['SSZD'] = '';
            }else{
                $c['SSZD'] = I('zd');
            }
            if((I('cz')?I('cz'):'') == '--请选择--'){
                $c['SSCZ'] = '';
            }else{
                $c['SSCZ'] = I('cz');
            }
            $c['SIM_CODE'] ='';
            $c['IMEI_CODE'] = I('pda_code')?I('pda_code'):'';
            $c1 = $c;
            $c1['sim']= $sim;
            $R = json_encode($c);
             
            $b_url = C('URL_BEFORE');
            $a_url = '/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr='.$R;
            $url = $b_url.$a_url;
            $RR =  postHttp($url);
            $R = json_decode($RR,true);
            //p($R );
            //分页
            $total  = $R[1]['totalNum'];
            $times = ceil($total/10);
            $this->assign('page',$page);
            $this->assign('per',$page-1);
            $this->assign('next',$page+1);
            $this->assign('total',$total);
            $this->assign('times',$times);
            //分页完
            $this->assign('c',$c1);
            $this->assign('R',$R);
            $this->assign("check",6);

            $this->assign('sim',$sim);
            $this->assign('dd', I('dd')?I('dd'):'--请选择--');
            $this->assign('zd', I('zd')?I('zd'):'--请选择--');
            $this->assign('cz', I('cz')?I('cz'):'--请选择--');


            if($sim == '删除PDA')
            {
                //$this->display('index_pda_end');
                 $this->assign('show','index_pda_end');
            }
            if($sim == '修改PDA')
            {
                //$this->display('index_pda_jy_end');
                 $this->assign('show','index_pda_jy_end');
            }
            if($sim == '查看PDA')
            {
                //$this->display('index_pda_se_end');
                $this->assign('show','index_pda_se_end');
            }
        /*}else{
            $this->assign('sim','删除PDA');
            $this->assign('dd', '--请选择--');
            $this->assign('zd', '--请选择--');
            $this->assign('cz', '--请选择--');
        }*/
        $this->display('index_pda');
    }
    //PDA查询结果
    public function index_pda_end(){
        $sim = I('sim');
        $page = I('page');
        if($page == '')
        {
            $page =1;
        }
        $c['startIndex'] = ($page-1)*10+0;
        $c['endIndex'] = ($page-1)*10+10;
        $c['ZFZH'] = I('ZFZH');
        $c['NAME'] = I('name');
        $c['ZFDWMC'] = I('dd');
        $c['SIM_CODE'] ='';
        $c['IMEI_CODE'] = I('pda_code');
        $c1 = $c;
        $c1['sim']= $sim;
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $R = json_decode($RR,true);
        //分页
        $total  = $R[1]['totalNum'];
        $times = ceil($total/10);
        $this->assign('page',$page);
        $this->assign('per',$page-1);
        $this->assign('next',$page+1);
        $this->assign('total',$total);
        $this->assign('times',$times);
        //分页完
        $this->assign('c',$c1);
        $this->assign('R',$R);
        $this->assign("check",6);
        if($sim == '删除PDA')
        {
            $this->display('index_pda_end');
        }
        if($sim == '修改PDA')
        {
            $this->display('index_pda_jy_end');
        }
        if($sim == '查看PDA')
        {
            $this->display('index_pda_se_end');
        }
    }
    public function index_pda_update(){
        $zfzh  = I('zfzh');
        $this->assign("zfzh",$zfzh);
        $this->assign("check",6);
        //$this->display('index_pda_update');
        $this->display('Admin_pda_Edit');
    }
    //ajax修改PDA
    function ajaxUpdatePda(){
        $c['NEW_IEMI_CODE'] =I('n_sim');
        $c['IMEI_CODE'] =I('old_sim');
        $c['ZFZH'] =I('zfzh');
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=update_Zfry_ImeiCode&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $CC = json_decode($RR,true);
        $this->ajaxReturn($CC);
    }
    //修改pda
    function toSelectPda(){
        $c['startIndex'] =+0;
        $c['endIndex'] = 10;
        $c['ZFZH'] = I('zfzh');
        $c['NAME'] = '';
        $c['ZFDWMC'] = '';
        $c['SIM_CODE'] ='';
        $c['IMEI_CODE'] = '';
        $c['SSZD'] = '';
        $c['SSCZ'] = '';
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $R = json_decode($RR,true);
        //p($R);
        $RC = $R[0];
        $this->assign("check",6);
        $this->assign('R',$RC);
        //$this->display('p_info');
        $this->display('Admin_pda_info');

    }

//重置密码
    function reSetPWD(){
        $zfzd = I('id');
        $this->assign("zfzd",$zfzd);
        $this->assign("check",10);
        $this->display('reSet_pwd');
    }
    function ajaxReSetPwd(){
        //$c['OLD_PWD'] = md5(I('old_pwd'));
        $new = I('new_pwd');
        $pattern='/^(?![a-zA-Z0-9]+$)(?![^a-zA-Z/D]+$)(?![^0-9/D]+$).{1,16}$/';
        $str=preg_match($pattern, $new);
        if(!$str){
            $this->ajaxReturn( array (
                "error" => 1,
                "errormsg" => "密码强度不符合,请重新输入"
            ), 'TEXT' );
        }
        //$sure = I('sure');
        $zf = I('zfzd');
        $zfd = explode(',',$zf);
        foreach ($zfd as $v){
            $zfr[] = "'".$v."'";
        }
        $zfzh = implode(',',$zfr);
        $b_url = C('URL_BEFORE');
        //requestApi/Powers?type=uptZfryPwd&zfzh='0000000'&pwd=zfzd
        $a_url = "/requestApi/Powers?type=uptZfryPwd&zfzh=".$zfzh."&pwd=".$new."";
        //echo "/requestApi/Powers?type=uptZfryPwd&zfzh=".$zfzh."&pwd=".$new."";
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $CC = json_decode($RR,true);
        $this->ajaxReturn($CC);

    }



    //修改密码页面
    public  function change_pwd(){
        $this->assign("check",6);
        $this->display('change_pwd');
    }
    //ajax修改密码
    function ajaxChangePwd(){
        $c['OLD_PWD'] = md5(I('old_pwd'));
        $c['PWD'] = md5(I('new_pwd'));
        //$sure = I('sure');
        $pattern='/^(?![a-zA-Z0-9]+$)(?![^a-zA-Z/D]+$)(?![^0-9/D]+$).{1,16}$/';
        $str=preg_match($pattern, $c['PWD']);
        if(!$str){
            $this->ajaxReturn( array (
                "error" => 1,
                "errormsg" => "密码强度不符合,请重新输入"
            ), 'TEXT' );
        }
        $c['ZFZH'] = $_SESSION['admin']['name'];
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=update_Zfry_Pwd&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $CC = json_decode($RR,true);
        $this->ajaxReturn($CC);

    }
    //删除用户
    function delPerson(){

        $c['ZFZH'] = I('ZFZH');
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=delete_Zfry_Info&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $CC = json_decode($RR,true);

        $this->ajaxReturn($CC);
    }

    //大队管理
    function DdList(){
        //大队
        /*$compName =  getCompName();
        $this->assign("compName",$compName);*/
        $zfzh = I("zfzh");
        $this->assign("zfzh",$zfzh);
        $this->assign("check",6);
        $this->display("DdList");
    }
    function ajaxDdList(){
        $zfzh = I("zfzh");

        //$c['zfzh'] = $zfzh?$zfzh:'';

        $offset = I('offset');
        $maxrows = I('maxrows');
        $c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows+$offset;
        //{"zfzh":"0000000","name":"貂蝉","sex":"女","dd":"北京市交通执法总队第五执法大队","startIndex":0,"endIndex":5}
        //requestApi/Powers?type=getConfigGroupInfo&zfzh=0000000
        //$arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=getConfigGroupInfo&zfzh=".$zfzh);
        $R = json_decode($R_json,true);
        $new_arr = array_slice($R,$offset,$maxrows);//取出数组中指定的长度
        $Res['rows'] = $new_arr;
        $Res['total'] = count($R);
        $this->ajaxReturn ($Res);
    }
    function addZfdw(){
        //大队
        $compName =  getCompName();
        $zfzh = I("zfzh");
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=getConfigGroupInfo&zfzh=".$zfzh);
        $R = json_decode($R_json,true);
        foreach ($R as $v){
            $Rz[] = $v['GROUPNAME'];
        }
        $compNameZ[0]['ZFDWMC'] = '全部';
        foreach ($compName as $k=>$v){
            if (!in_array($v['ZFDWMC'],$Rz)){
                unset($k);
                $compNameZ[] = $v;
            }
        }
        $this->assign("compNameZ",$compNameZ);
        $this->assign("zfzh",$zfzh);
        $this->assign("check",6);
        $this->display("addZfdw");
    }
    function ajaxaddZfdw(){
        //requestApi/bs_Taxi?type=addUser&jsonStr={"zfzh":"1111112","name":"貂蝉姐","sex":"女","zfdwmc":"北京市交通执法总队第五执法大队","role_id":"4","pwd":"123","sszd":"二中隊","sscz":"二車組","phone":"12112111211","sjssdwmc":"交委"}
        //账号,姓名,性别,组织
        $zfzh = I("zfzh");//账号
        $zfdw = I("zfdw");//姓名

        if($zfdw=='全部'){
            $R_json1 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=getConfigGroupInfo&zfzh=".$zfzh);
            $R1 = json_decode($R_json1,true);
            $compName =  getCompName();
            foreach ($R1 as $v){
                $Rz[] = $v['GROUPNAME'];
            }
            foreach ($compName as $k=>$v){
                if (!in_array($v['ZFDWMC'],$Rz)){
                    unset($k);
                  $R_json[$k] =  postHttp(C("URL_BEFORE")."/requestApi/Powers?type=configGroup&zfzh=".$zfzh."&zfdw=".$v['ZFDWMC']);
                  //p($R_json[$k]);
                }
            }
            $R = array("error"=>"0","msg"=>"保存成功!");
        }else{
           $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=configGroup&zfzh=".$zfzh."&zfdw=".$zfdw);
            //echo C("URL_BEFORE")."/requestApi/Powers?type=configGroup&zfzh=".$zfzh."&zfdw=".$zfdw;
            $R = json_decode($R_json,true); 
        }
        //$phone = I("phone");
        //$sjssdwmc = I("sjssdwmc");
        
        $this->ajaxReturn ($R);
    }

    function editZfdw(){
        //大队
        $compName =  getCompName();
        //绑定的大队
        $zfzh = I('zfzh');
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=getConfigGroupInfo&zfzh=".$zfzh);
        $R = json_decode($R_json,true);
        foreach ($R as $v){
            $Rz[] = $v['GROUPNAME'];
        }
        $id = I('id');
        $zfdw = I('zfdw');
        $this->assign("Rz",$Rz);
        $this->assign("compName",$compName);
        $this->assign("id",$id);
        $this->assign("zfdw",$zfdw);
        $this->display("editZfdw");
    }
    function ajaxEditZfdw(){
        $id = I('id');
        $zfdw = I('zfdw');
        ///requestApi/Powers?type=updateGroupName&jsonStr={"new_mc":"14","id":"bfe9254e275d447bb84d7b93577a53f8"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=uptConfigGroup&id=".$id."&zfdw=".$zfdw);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }
    function zfdwDel(){
        $id = I("id");
        ///requestApi/Powers?type=delGroupName&jsonStr={"id":"bfe9254e275d447bb84d7b93577a53f8"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=delConfigGroup&id="."'$id'");
        //echo C("URL_BEFORE")."/requestApi/Powers?type=delConfigGroup&id="."\'$id\'";
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }
    //角色管理
    function user(){
        //p(I('post.'));
        $c['ZFZH'] = $_SESSION['admin']['name'];
        $R = json_encode($c);
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/permission?type=query_Next_Role&jsonStr='.$R;
        $url = $b_url.$a_url;
         
        $compName = getCompName();
        $RR =  postHttp($url);
        $CC = json_decode($RR,true);
        $this->assign("compName",$compName);
        $this->assign("CC",$CC);
        $this->assign("check",6);
        /*if(IS_POST||(IS_GET && I('page'))){*/
            //p(I('post.'));
             $c['NAME'] = I('name')?I('name'):'';
            if((I('dd')?I('dd'):'') == '--请选择--')
            {
               $c['ZFDWMC'] = '';
            }else{
               $c['ZFDWMC'] = I('dd')?I('dd'):'';
            }
            
           
            if((I('qx')?I('qx'):'') == '--请选择--')
            {
                $c['ROLE_ID'] = '';
            }
            else
            {
                $c['ROLE_ID'] = I('qx')?I('qx'):4;
            }
            if((I('zd')?I('zd'):'') == '--请选择--'){
                $c['SSZD'] = '';
            }else{
                $c['SSZD'] = I('zd');
            }
            if((I('cz')?I('cz'):'') == '--请选择--'){
                $c['SSCZ'] = '';
            }else{
                $c['SSCZ'] = I('cz');
            }

            $page = I('page')?I('page'):'';
            if($page == '')
            {
                $page =1;
            }
            $c['startIndex'] = ($page-1)*10+0;
            $c['endIndex'] = ($page-1)*10+10;
            $c['ZFZH'] = I('ZFZH')?I('ZFZH'):'';
            //$c['ROLE_ID'] = I('qx');
            $R = json_encode($c);
             //p($c);
            $b_url = C('URL_BEFORE');
            $a_url = '/requestApi/permission?type=query_next_info&jsonStr='.$R;
            $url = $b_url.$a_url;
            $RR =  postHttp($url);
            $CC = json_decode($RR,true);
            $total  = $CC[0]['totalNum'];
            $times = ceil($total/10);
            $this->assign('page',$page);
            $this->assign('per',$page-1);
            $this->assign('next',$page+1);
            $this->assign('total',$total);
            $this->assign('times',$times);
            $this->assign('ZFZH', I('ZFZH')?I('ZFZH'):'');
            $this->assign('name', I('name')?I('name'):'');
            $this->assign('dd', I('dd')?I('dd'):'--请选择--');
            $this->assign('zd', I('zd')?I('zd'):'--请选择--');
            $this->assign('cz', I('cz')?I('cz'):'--请选择--');
            $this->assign('show_qx', I('show_qx')?I('show_qx'):'--请选择--');
            $this->assign('qx', I('qx')?I('qx'):4);
            //p(I('post.'));
            $this->assign('c',$c);
            $this->assign("R",$CC);
            
            if($total){
                $this->assign('show','index_user_jy_end');
            }else{
                $this->assign('errormsg','暂无数据');
            }
        /*}else{

            $this->assign('dd', '--请选择--');
            $this->assign('zd', '--请选择--');
            $this->assign('cz', '--请选择--');
            $this->assign('show_qx', '--请选择--');
        }*/
        $this->display('user');
    }
    function  getRole(){

        $c['NAME'] = I('name');
        if(I('ZHDWMC') == '--请选择--')
        {
            $c['ZFDWMC'] = '';
        }
        else
        {
            $c['ZFDWMC'] = I('ZHDWMC');
        }
        $page = I('page');
        if($page == '')
        {
            $page =1;
        }
        $c['startIndex'] = ($page-1)*10+0;
        $c['endIndex'] = ($page-1)*10+10;
        $c['ZFZH'] = I('ZFZH');
        $c['ROLE_ID'] = I('qx');
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/permission?type=query_next_info&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $CC = json_decode($RR,true);
        $total  = $CC[0]['totalNum'];
        $times = ceil($total/10);
        $this->assign('page',$page);
        $this->assign('per',$page-1);
        $this->assign('next',$page+1);
        $this->assign('total',$total);
        $this->assign('times',$times);
        $this->assign('c',$c);
        $this->assign("R",$CC);

        $this->display('index_user_jy_end');
    }
    //修改quanxia
    public function index_user_update(){
        $c['ZFZH'] = $_SESSION['admin']['name'];
        $R = json_encode($c);
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/permission?type=query_Next_Role&jsonStr='.$R;
        $url = $b_url.$a_url;
         
        $RR =  postHttp($url);
        $CC = json_decode($RR,true);
        $zfzh  = I('zfzh');
        $role_id = I('role_id');
        $name = I('name');
        $role_name = I('role_name');
        $this->assign("role_id",$role_id);
        $this->assign("name",$name);
        $this->assign("role_name",$role_name);
        $this->assign("CC",$CC);
        $this->assign("zfzh",$zfzh);
        $this->assign("check",6);
        //$this->display('index_user_update');
        $this->display('Admin_user_Edit');
    }
    //修改权限
    function updateRole(){
        $c['ROLE_ID'] = I("role_id");
        $c['ZFZH']    = I('ZFZH');
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/permission?type=update_Zfry_Role&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        if($RR){
            $this->ajaxReturn ( array (
                "err" => 0,
                "errorMsg" => "修改成功" 
            ) );
            return;
        }else{
            $this->ajaxReturn ( array (
                "err" => 0,
                "errorMsg" => "修改失败" 
            ) );
            return;
        }
        //$this->ajaxReturn($RR);
    }
    //添加用户
    function  addUser(){
        $c['ZFZH'] = $_SESSION['admin']['name'];
        $R = json_encode($c);
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/permission?type=query_Next_Role&jsonStr='.$R;
        $url = $b_url.$a_url;
         
        $compName = getCompName();
        $RR =  postHttp($url);
        $CC = json_decode($RR,true);
        $this->assign("compName",$compName);
        $this->assign("R1",$CC);
        $this->assign("check",6);
        //$this->display('index_user_add');
        $this->display('Admin_user_add');
    }
    //ajax添加用户
    function ajaxAddUser(){
        $c['ZFZH'] = I('zfzh');//执法证号
        $c['NAME'] = I('name');//姓名
        $c['SEX'] = I('sex');

        $c['ZFDWMC'] = I('zfdwmc');
        $c['SSZD'] = I('sszd');
        $c['SSCZ'] = I('sscz');
        $c['SJSSDWMC'] = I('sjssdwmc');//上级单位
        $c['TELPHONE'] = I('phone');
        $c['PWD'] = I('pwd');

        $c['ROLE_ID'] = I('role_id');
        
        
        
        
        
        
        
        $R = json_encode($c);
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=save_Zfry_Info&jsonStr='.$R;
        $url = $b_url.$a_url;
         
        $RR =  postHttp($url);
        $CC = json_decode($RR,true);
        $this->ajaxReturn($CC);
    }


    //禁用和恢复
    function casPerson(){
        $c['ZFZH'] = I('ZFZH');
        $c['ZHZT'] = I('cc');
        $R = json_encode($c);
         
        $b_url = C('URL_BEFORE');
        $a_url = '/requestApi/zfry?type=update_Zfry_Status&jsonStr='.$R;
        $url = $b_url.$a_url;
        $RR =  postHttp($url);
        $CC = json_decode($RR,true);

        $this->ajaxReturn($CC);
    }

function getGroups(){
    $zfdwmc = I('zfdwmc');
    $sszd = I('sszd');
    $url_b = C("URL_BEFORE");
    //$url = $url_b."/requestApi/zhifache?type=getCorpList";
    $url = $url_b.'/requestApi/zfry?type=getGroups&jsonStr={"zfdwmc":"'.$zfdwmc.'","sszd":"'.$sszd.'"}';
   
    $Groups = postHttp($url);
    $json = json_decode(trim($Groups,chr(239).chr(187).chr(191)),true);
    $this->ajaxReturn ($json);
}

/****************2016-9-19**chenchaun**add*****************/

/**
 * 用户列表
 */
function Admin_UserList(){
    $this->assign("check",6);

    $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryRole");
        
    $R = json_decode($R_json,true);


    $this->assign("rnames",$R);
//大队
    $compName =  getCompName();
    $this->assign("compName",$compName);
    $this->display("Admin_UserList");
}
function ajaxUserList(){
    //123.57.236.212:8080/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr={"startIndex":0,"endIndex":10,"ZFZH":"","NAME":"","ZFDWMC":"","SSZD":"","SSCZ":"","SIM_CODE":"","IMEI_CODE":""}
    
    $ZFZH = I('zfzh');
    $NAME = I('name');
    $ZFDWMC = I('dd');
    $SSZD = I('zd');
    $SSCZ = I('cz');
    $SIM_CODE = I('sim');
    $IMEI_CODE = I('imei_code');

    $RNAME = I("rname");//"rname":"超级管理员"

    if($ZFDWMC != '全部'){
        $c['ZFDWMC'] = $ZFDWMC;
    }else{
        $c['ZFDWMC'] = '';
    }
    if($SSZD != '全部'){
        $c['SSZD'] = $SSZD;
    }else{
        $c['SSZD'] = '';
    }
    if($SSCZ != '全部'){
        $c['SSCZ'] = $SSCZ;
    }else{
        $c['SSCZ'] = '';
    }

    if($RNAME != '全部'){
        $c['RNAME'] = $RNAME;
    }else{
        $c['RNAME'] = '';
    }

    $c['ZFZH'] = $ZFZH;
    $c['NAME'] = $NAME;

    
    if($SIM_CODE != ''){
        $c['SIM_CODE'] = $SIM_CODE;
    }else{
        $c['SIM_CODE'] = '';
    }
    if($IMEI_CODE != ''){
        $c['IMEI_CODE'] = $IMEI_CODE;
    }else{
        $c['IMEI_CODE'] = '';
    }
    

    $offset = I('offset');
    $maxrows = I('maxrows');
    $c['startIndex'] = $offset;
    $c['endIndex'] = $maxrows+$offset;

    $arr_json = json_encode($c);
     
    $R_json = postHttp(C('URL_BEFORE').'/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr='.$arr_json);
    //echo C('URL_BEFORE').'/requestApi/zfry?type=bs_Query_Zfry_Info&jsonStr='.$arr_json;
    $Res = json_decode($R_json,true);
    $R['total'] = $Res[0]['totalNum'];
    $R['rows'] = $Res;

    //p($R);
    $this->ajaxReturn ($R);
}

/**
 * SIM卡管理
 */
function Admin_sim(){
    $this->assign("check",6);
    //大队
    $compName =  getCompName();
    $this->assign("compName",$compName);
    $this->display("Admin_sim");
}

/**
 * 
 */
function Admin_pda(){
    $this->assign("check",6);
    //大队
    $compName =  getCompName();
    $this->assign("compName",$compName);
    $this->display("Admin_pda");
}

function Admin_user(){
    $c['ZFZH'] = $_SESSION['admin']['name'];
    $R = json_encode($c); 
    $url = C('URL_BEFORE').'/requestApi/permission?type=query_Next_Role&jsonStr='.$R;
     
    $compName = getCompName();
    $RR =  postHttp($url);
    $CC = json_decode($RR,true);
    $this->assign("CC",$CC);
    $this->assign("check",6);

    //大队
    $compName =  getCompName();
    $this->assign("compName",$compName);
    $this->display("Admin_user");
}
function ajaxAdminUser(){ 

    $dd= I('dd');
    $zd= I('zd');
    $cz= I('cz');
    $zfzh= I('zfzh');
    $name= I('name');
    $qx= I('qx');

    if($dd != '全部'){
       $c['ZFDWMC'] = $dd;
    }else{
        $c['ZFDWMC'] = '';
    }
    if($zd != '全部'){
        $c['SSZD'] = $zd;
    }else{
        $c['SSCZ'] = '';
    }
    if($cz != '全部'){
        $c['SSCZ'] = $cz;
    }else{
        $c['SSCZ'] = '';
    }

    $c['NAME'] = $name; 
    $c['ROLE_ID'] = $qx;
    $c['ZFZH'] = $zfzh;

    $offset = I('offset');
    $maxrows = I('maxrows');
    $c['startIndex'] = $offset;
    $c['endIndex'] = $maxrows+$offset;

    $arr_json = json_encode($c);
    $R_json =  postHttp(C('URL_BEFORE').'/requestApi/permission?type=query_next_info&jsonStr='.$arr_json);


    $Res = json_decode($R_json,true);
    $R['total'] = $Res[0]['totalNum'];
    $R['rows'] = $Res;

    //p($R);
    $this->ajaxReturn ($R);
}

/* 角色管理*/
    /**
     * 角色分类
     */
    function roleStyle(){
        $this->assign("check",6);
        $this->display("roleStyle");
    }
    function ajaxroleStyle(){

        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryRole");

        $R = json_decode($R_json,true);
        $res['total'] =count($R);
        $res['rows'] = $R;
        $this->ajaxReturn ($res);
    }

    /**
     * 角色分类(add)
     */
    function addRoleStyle(){
        /*查询角色用户表*/

        $this->assign("check",6);
        $this->display("addRoleStyle");
    }
    function ajaxaddRoleStyle(){
        $mc = I('mc');
        $ms = I('ms');

        $c['mc'] = $mc;
        $c['ms'] = $ms;

        $arr_json = json_encode($c);
        //requestApi/Powers?type=setRole&jsonStr={"mc":"011"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=setRole&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 角色名称(edit)
     */
    function editRoleStyle(){
        $R_json1 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryFunction_All");
        //echo C("URL_BEFORE")."/requestApi/Powers?type=queryGroup_All";
        $R1 = json_decode($R_json1,true);
        //$Res['total'] = count($R1);
        $this->assign('R1',$R1);
        $id = I('id');
        $rolename = I('mc');
        $ms = I('ms');
        //$g_id = I('g_id');

        $this->assign("id",$id);
        // $this->assign("g_id",$g_id);
        $this->assign("rolename",$rolename);
        $this->assign("ms",$ms);
        $this->assign("check",6);
        $this->display("editRoleStyle");
    }
    function ajaxeditRoleStyle(){
        $id = I('id');
        $new_mc = I('new_mc');
        $ms = I('ms');

        $c['id'] = $id;
        $c['new_mc'] = $new_mc;
        $c['ms'] = $ms;





        $arr_json = json_encode($c);
        //requestApi/Powers?type=setRole_Function&jsonStr={"acl_id":"7b2f0ad76cc44153842e19aa49132136","role_id":"06ee0e2e7ca94703b428cc341216ae01"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=updateRoleName&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /**
     * 角色分类(del)
     */
    function delRoleStyle(){
        $id = I("id");

        $c['id'] = $id;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=delRoleName&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }

    /*角色功能管理*/
    public function RolePower(){
        /*查询所有的功能*/
        /*查询所有的功能*/
        $c8['mark'] = 'road';
        $arr_json8 = json_encode($c8);
        $R_json1 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryFunction_All&jsonStr=".$arr_json8);
        $R1 = json_decode($R_json1,true);
        //p($R1);

        $c9['mark'] = 'road_app';
        $arr_json9 = json_encode($c9);
        $R_json9 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryFunction_All&jsonStr=".$arr_json9);
        //echo C("URL_BEFORE")."/requestApi/Powers?type=queryGroup_All";
        $R9 = json_decode($R_json9,true);
        $Rz = array_merge($R1, $R9);
        //$Res['total'] = count($R1);
        $this->assign('Rz',$Rz);
        /*查询该角色已绑定的功能*/
        $id = I('id');
        $this->assign('id',$id);
        $c['id']=$id;
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=getFunctionByRolId&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        // p($R);
        foreach ($R as $val){
            $R2[]=$val['ID'];
        }
        //p($R3);
        $this->assign('R2',$R2);
        $this->display('editRolePower');
    }
    /*给角色绑定功能*/
    public function ajaxRolePower(){

        $id = I('id');
        /*查询该角色已绑定的功能*/
        $c['id']=$id;
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=getFunctionByRolId&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $acl_id = $_POST['acl_id'];
        $c['role_id'] = $id;
        $err = false;
        foreach ($acl_id as $v) {
            $c['acl_id'] = $v;

            $arr_json11 = json_encode($c);
            //$this->ajaxReturn($arr_json1);
            $R_json11 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=setRole_Function&jsonStr=".$arr_json11);
            //p($R_json);
            $R11 = json_decode($R_json11,true);
            if($R11['error']==0){
                $err = true;
            }
            if($R11['error']==3){
                $errs = true;
            }
        }
        //print_r($R);
        /*查询所有的功能*/
        $c8['mark'] = 'road';
        $arr_json8 = json_encode($c8);
        $R_json1 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryFunction_All&jsonStr=".$arr_json8);
        $R1 = json_decode($R_json1,true);
        //p($R1);

        $c9['mark'] = 'road_app';
        $arr_json9 = json_encode($c9);
        $R_json9 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryFunction_All&jsonStr=".$arr_json9);
        //echo C("URL_BEFORE")."/requestApi/Powers?type=queryGroup_All";
        $R9 = json_decode($R_json9,true);
        $Rz = array_merge($R1, $R9);
        $str = "";
        foreach ($Rz as $key=>$val){
            if (in_array($val['ID'],$acl_id)){
                unset($Rz[$key]);
            }
        }
        foreach ($Rz as $val){
            $str .= "'".$val['ID']."',";
        }
        $str2 = rtrim($str,",");
        $c12['acl_id'] = $str2;
        $c12['role_id'] = $id;
        $arr_json12 = json_encode($c12);
        $R_json12 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=delRole_Function_New&jsonStr=".$arr_json12);
        //echo C("URL_BEFORE")."/requestApi/Powers?type=delRole_Function_New&jsonStr=".$arr_json12;
        $R12 = json_decode($R_json12,true);
        $err2 = false;
        if($R12['error']==0){
            $err2 = true;
        }
        /*if(empty($R11)){
            $this->ajaxReturn(
                array(
                    'error'=>0,
                )
            );
        }else{
            $this->ajaxReturn ($R11);
        }*/

        if($err==true&&$err2==false&&$errs==true){
            $this->ajaxReturn(
                array(
                    'error'=>0,
                    'msg' => '绑定成功'
                )
            );
        }

        if($err==true&&$err2==false&&$errs==null){
            $this->ajaxReturn(
                array(
                    'error'=>0,
                    'msg' => '绑定成功'
                )
            );
        }
        if($err==false&&$err2==true&&$errs==true){
            $this->ajaxReturn(
                array(
                    'error'=>0,
                    'msg' => '解除绑定成功'
                )
            );
        }
        if($err==false&&$err2==true&&$errs==null){
            $this->ajaxReturn(
                array(
                    'error'=>0,
                    'msg' => '解除绑定成功'
                )
            );
        }
        if($err==false&&$err2==false&&$errs==null){
            $this->ajaxReturn(
                array(
                    'error'=>1,
                    'msg' => '未绑定任何功能'
                )
            );
        }
        if($err==false&&$err2==false&&$errs==true){
            $this->ajaxReturn(
                array(
                    'error'=>1,
                    'msg' => '请勿重复绑定'
                )
            );
        }
        if($err==true&&$err2==true&&$errs==true){
            $this->ajaxReturn(
                array(
                    'error'=>0,
                    'msg' => '绑定成功'
                )
            );
        }
    }
    /*给角色解除绑定功能*/
    public function delRolePower(){

        $id = I('id');
        $c['id'] = $id;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=delRole_Function&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }

    /**
     * 功能管理
     */
    public function Powerful(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60)) );

        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);

        $this->assign("check",6);
        $this->display("Powerful");
    }
    public function Powerfulapp(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60)) );

        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);

        $this->assign("check",6);
        $this->display("Powerfulapp");
    }
    function ajaxPowerful(){

        $offset = I('offset');
        $maxrows = I('maxrows');

        $c['mark'] = 'road';
        $arr_json = json_encode($c);
        /*$arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryGroupName&jsonStr=".$arr_json);*/
        ///requestApi/Powers?type=queryGroupName&jsonStr={"mc":"11"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryFunction_All&jsonStr=".$arr_json);
        //echo C("URL_BEFORE")."/requestApi/Powers?type=queryGroup_All";
        $R = json_decode($R_json,true);
        $new_arr = array_slice($R,$offset,$maxrows);//取出数组中指定的长度
        $Res['rows'] = $new_arr;
        $Res['total'] = count($R);
        $this->ajaxReturn ($Res);
    }
    function ajaxPowerfulapp(){

        
        $offset = I('offset');
        $maxrows = I('maxrows');
        
        $c2['mark'] = 'road_app';
        $arr_json2 = json_encode($c2);
        $R_json2 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryFunction_All&jsonStr=".$arr_json2);
        $R2 = json_decode($R_json2,true);
        $new_arr = array_slice($R2,$offset,$maxrows);//取出数组中指定的长度
        /*$Rz = array_merge($R, $R2);*/
        $Res['rows'] = $new_arr;
        $Res['total'] = count($R2);
        $this->ajaxReturn ($Res);
    }
    /**
     * 功能管理(add)
     */
    function addPowerful(){
        $this->assign("check",6);
        $this->display("addPowerful");
    }
    function ajaxaddPowerful(){
        ///requestApi/Powers?type=setGroup&jsonStr={"mc":"11"}
        $mc = I('mc');
        $ms = I('ms');
        $c['mc'] = $mc;
        $c['ms'] = $ms;
        $men=explode("-",$mc);
        $type=$men[0];
        if ($type=='BS'){
            $c['mark'] = 'road';
        }elseif($type=='APP'){
            $c['mark'] = 'road_app';
        }
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=setFunction&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }
    /**
     * 功能组织
     */
    function PowerfulEdit(){
        $id = I('id');
        $mc = I('mc');
        $ms = I('ms');
        $this->assign("id",$id);
        $this->assign("mc",$mc);
        $this->assign("ms",$ms);
        $this->display("editPowerful");
    }
    function ajaxEditPowerful(){
        $id = I('id');
        $name = I('name');
        $ms = I('ms');

        $c1['new_mc'] = $name;
        $c1['ms'] = $ms;
        $c1['id'] = $id;
        $arr_json1 = json_encode($c1);
        ///requestApi/Powers?type=updateGroupName&jsonStr={"new_mc":"14","id":"bfe9254e275d447bb84d7b93577a53f8"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=updateFunctionName&jsonStr=".$arr_json1);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }
    function PowerfulDel(){
        $id = I("id");

        $c['id'] = $id;

        $arr_json = json_encode($c);
        ///requestApi/Powers?type=delGroupName&jsonStr={"id":"bfe9254e275d447bb84d7b93577a53f8"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=delFunctionName&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }
/****************2016-9-19*****chenchaun*****************/

        
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

    /**
     * 组织管理
     */
    public function Organization(){
        $this->assign ( "startDate", date ( 'Y-m-d', time () ) . " 00:00:00" );
        //$this->assign ( "startDate", "2016-08-01 00:00:00" );
        $this->assign ( "endDate", date ( 'Y-m-d H:i:s', (time ()-60)) );

        //大队
        $compName =  getCompName();
        $this->assign("compName",$compName);

        $this->assign("check",6);
        $this->display("Organization");
    }
    function ajaxOrganization(){

        $offset = I('offset');
        $maxrows = I('maxrows');
        /*$c['startIndex'] = $offset;
        $c['endIndex'] = $maxrows;*/

        /*$arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryGroupName&jsonStr=".$arr_json);*/
        ///requestApi/Powers?type=queryGroupName&jsonStr={"mc":"11"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryGroup_All");
        //echo C("URL_BEFORE")."/requestApi/Powers?type=queryGroup_All";
        $R = json_decode($R_json,true);
        $Res['rows'] = $R;
        $Res['total'] = count($R);
        $this->ajaxReturn ($Res);
    }
    /**
     * 组织管理(add)
     */
    function addOrganization(){
        $this->assign("check",6);
        $this->display("addOrganization");
    }
    function ajaxaddOrganization(){
        ///requestApi/Powers?type=setGroup&jsonStr={"mc":"11"}
        $mc = I('mc');
        $c['mc'] = $mc;

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=setGroup&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }
    /**
     * 修改组织
     */
    function OrganizationEdit(){
        $id = I('id');
        $mc = I('mc');
        $this->assign("id",$id);
        $this->assign("mc",$mc);
        $this->display("editOrganization");
    }
    function ajaxEditOrganization(){
        $id = I('id');
        $name = I('name');

        $c1['new_mc'] = $name;
        $c1['id'] = $id;
        $arr_json1 = json_encode($c1);
        ///requestApi/Powers?type=updateGroupName&jsonStr={"new_mc":"14","id":"bfe9254e275d447bb84d7b93577a53f8"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=updateGroupName&jsonStr=".$arr_json1);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }
    function OrganizationDel(){
        $id = I("id");

        $c['id'] = $id;

        $arr_json = json_encode($c);
        ///requestApi/Powers?type=delGroupName&jsonStr={"id":"bfe9254e275d447bb84d7b93577a53f8"}
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=delGroupName&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        $this->ajaxReturn ($R);
    }

    /*组织绑定角色*/
    function OrganizationRole(){
        /*查询所有角色*/
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryRole");
        $R = json_decode($R_json,true);
        $this->assign("R",$R);
        /*查询已绑定的角色*/
        $group_id = I("group_id");

        $c['id'] = $group_id;

        $arr_json1 = json_encode($c);
        $R_json1 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryGroupRoleName&jsonStr=".$arr_json1);
        $R1 = json_decode($R_json1,true);
        foreach ($R1 as $val){
            $R2[]=$val['ID'];
        }
        // p($R2);
        $this->assign("R2",$R2);
        $this->assign("group_id",$group_id);
        $this->assign("check",6);
        $this->display("OrganizationRole");
    }
    function ajaxOrganizationRole(){
        $group_id = I("group_id");
        $role_id = I("role_id");
        /*查询用户是否绑定角色*/
        $c2['id'] = $group_id;

        $arr_json3 = json_encode($c2);
        $R_json3 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryGroupRoleName&jsonStr=".$arr_json3);
        $R3 = json_decode($R_json3,true);
        if (!empty($R3)){
            //$this->ajaxReturn('您已经添加过角色了，如要修改，请先解除！');
            $arr_json5 = json_encode($c2);
            $R_json5 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=delGroup_Role&jsonStr=".$arr_json5);
            $R5 = json_decode($R_json5,true);
            if ($R5['error']==0){
                $c['group_id'] = $group_id;
                $c['id'] = $role_id;
                $arr_json1 = json_encode($c);
                $R_json1 = postHttp(C("URL_BEFORE") . "/requestApi/Powers?type=setGroup_Role&jsonStr=" . $arr_json1);
                $R1 = json_decode($R_json1, true);
                $this->ajaxReturn($R1);
            }else{
                $this->ajaxReturn(
                    array(
                        'error'=>0,
                        'msg'=>'添加失败！'
                    )
                );
            }
        }else{
            /*绑定角色*/
            $c8['group_id'] = $group_id;
            $c8['id'] = $role_id;
            $arr_json8 = json_encode($c8);
            $R_json8 = postHttp(C("URL_BEFORE") . "/requestApi/Powers?type=setGroup_Role&jsonStr=" . $arr_json8);
            $R8 = json_decode($R_json8, true);
            $this->ajaxReturn($R8);
        }
    }
    /*解除绑定*/
    function delOrgaRole(){
        $group_id = I("group_id");
        $c['id'] = $group_id;
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=delGroup_Role&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $this->ajaxReturn ($R);
    }
    /*************************/

    /*用户管理->角色功能*/
    public function showPower(){
        /*查询所有的功能*/
        /*查询所有的功能*/
        $c8['mark'] = 'road';
        $arr_json8 = json_encode($c8);
        $R_json1 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryFunction_All&jsonStr=".$arr_json8);
        $R1 = json_decode($R_json1,true);
        //p($R1);

        $c9['mark'] = 'road_app';
        $arr_json9 = json_encode($c9);
        $R_json9 = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=queryFunction_All&jsonStr=".$arr_json9);
        //echo C("URL_BEFORE")."/requestApi/Powers?type=queryGroup_All";
        $R9 = json_decode($R_json9,true);
        $Rz = array_merge($R1, $R9);
        //$Res['total'] = count($R1);
        $this->assign('Rz',$Rz);
        /*查询该角色已绑定的功能*/
        $id = I('id');
        $this->assign('id',$id);
        $c['id']=$id;
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/Powers?type=getFunctionByRolId&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        // p($R);
        foreach ($R as $val){
            $R2[]=$val['ID'];
        }
        //p($R3);
        $this->assign('R2',$R2);
        $this->display('showPower');
    }

    //查看用户信息
    function showme(){
        $zfzh = I("zfzh");
        $rolename = I("rolename");
        $c['zfzh'] = $zfzh;
       
        //requestApi/bs_Taxi?type=UserAllList&jsonStr={"zfzh":"0000000","name":"貂蝉","sex":"女","dd":"北京市交通执法总队第五执法大队"}
        //大队
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=viewUser&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        
        $array['SSCZ'] = '';
        foreach ($R['rows'] as $key => $value) {
            $array['ZFZH'] = $value['ZFZH'];
            $array['NAME'] = $value['NAME'];
            $array['SEX'] = $value['SEX'];
            $array['ZFDWMC'] = $value['ZFDWMC'];
            $array['SJSSDWMC'] = $value['SJSSDWMC'];
            $array['TELPHONE'] = $value['TELPHONE'];
            $array['PHOTO'] = $value['PHOTO'];
            $array['FEEDBACK'] = $value['FEEDBACK'];
            $array['T_ROW_ID'] = $value['T_ROW_ID'];
            $array['SIM_CODE'] = $value['SIM_CODE'];
            $array['IMEI_CODE'] = $value['IMEI_CODE'];
            $array['SSZD'] = $value['SSZD'];
            $array['ZHZT'] = $value['ZHZT'];
            $array['LOGINSTATUS'] = $value['LOGINSTATUS'];
            $array['TYPE'] = $value['TYPE'];
            $array['ZDID'] = $value['ZDID'];
            $array['USERNAME'] = $value['USERNAME'];
            $array['SSCZ'] = $array['SSCZ'].','.$value['SSCZ'];
        }
        //p($array);
        $array['rolename'] = $rolename;
        $array['SSCZ'] = ltrim($array['SSCZ'], ",");
        $compName =  getCompName();
        $this->assign("R",$array);
        $this->assign("compName",$compName);

        $this->assign("check",6);
        $this->display("showUser");
    }
}