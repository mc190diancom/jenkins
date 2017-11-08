<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/18
 * Time: 9:08
 */

namespace Home\Controller;


use Home\Model\LoginModel;
use Think\Controller;
use Think\Model;

class BestController extends Controller
{
   /* public function __construct(){
        header("content-type:text/html;charset=utf-8");

        parent::__construct();//执行一次父类的构造方法
        if(!session("?admin"))
        {
           $this->redirect('Login/login');
        }
        else{
            $menu = C("MENU");
            $ZFZH = $_SESSION['admin']['name'];
            $before_url = C("URL_BEFORE");
            $a_url = '/requestApi/permission?type=queryPermission&jsonStr={"ZFZH":"'.$ZFZH.'"}';
            $url = $before_url.$a_url;          
            $RR = postHttp($url);
            $this->assign("menu",$menu);
        }
    }*/

    protected function _initialize(){
        $c_time = time()-$_SESSION ['admin']['time'];
        if($c_time > 300 && $c_time < 60480){
            setcookie('ADMIN[0]',"",time()-3600*24*7, '/', '');
            setcookie('ADMIN[1]',"",time()-3600*24*7, '/', '');
            setcookie('ADMIN[2]',"",time()-3600*24*7, '/', '');
            setcookie('ADMIN[3]',"",time()-3600*24*7, '/', '');
            setcookie('ADMIN[4]',"",time()-3600*24*7, '/', '');
            setcookie('ADMIN',"",time()-3600*24*7, '/', '');
            session("admin",null);
            echo "<script>alert('在线超出时长，请重新登录');</script>";
            echo "<script>top.location.href='".__APP__."/Home/Login/login';</script>";
            exit;
        }
        //sleep(1);
        $_SESSION ['admin']['time'] = time();
        //p($_COOKIE);
        if($_COOKIE["ADMIN"]){  
            $mobile = $_COOKIE["ADMIN"]['0'];
            $pwd = $_COOKIE["ADMIN"]['1'];
            $userName = $_COOKIE["ADMIN"]['2'];
            $rode = $_COOKIE["ADMIN"]['3'];
            $pwds = $_COOKIE["ADMIN"]['4'];
            
            $c ['name'] = decode($mobile);
            $c ['pwd'] = decode($pwd);
            $c ['userName'] = decode($userName);
            $c ['rode'] = decode($rode);
            $c ['pwds'] = decode($pwds);
            
            //$_SESSION ['admin'] = $c;
        }

        if(!$_SESSION ['admin']['name']){
            //$this->redirect('Login/login');
            echo "<script>alert('在线超出时长，请重新登录');</script>";
            echo "<script>top.location.href='".__APP__."/Home/Login/login';</script>";
           exit;
        }else{
            $menu = C("MENU");
            $ZFZH = $_SESSION['admin']['name'];
            $menu = C("MENU");
            $ZFZH = $_SESSION['admin']['name'];
            $rode = $_SESSION['admin']['rode'];
            //var_dump($_SESSION);DIE;
            if ($rode == ''){
                $newMenu[] = $menu[0];
                $newMenu[] = $menu[2];
            }else{
               /* //查询该用户的角色
                $role=postHttp(C('URL_BEFORE').'/requestApi/Powers?type=getRoleByZfzh&jsonStr={"zfzh":"'.$ZFZH.'"}');
                $rol=json_decode($role,ture);
                foreach ($rol as $v){
                    $role_id=$v[ID];
                }*/
                //p($menu);
                //通过角色id查询功能
                $power=postHttp(C('URL_BEFORE').'/requestApi/Powers?type=getFunctionByRolId&jsonStr={"id":"'.$rode.'"}');
                $powerful=json_decode($power,ture);
                //print_r($powerful);
                foreach ($powerful as $val){
                    /*if ($val['NAME'] = 'BS-稽查记录修改和删除'){
                        $_SESSION['save'] = '9';
                    }*/
                    $type=explode("_",$val[MARK]);
                    //print_r($type);
                    if ($type[0]=='road'&&$type[1]=='') {
                        $men = explode("-", $val[NAME]);
                        $me[] = $men[1];
                    }
                }

                if (in_array('稽查记录修改和删除',$me)){
                    $_SESSION['save'] = '9';
                }else{
                    $_SESSION['save'] = '';
                }
                foreach ($menu as $v){
                    if (!in_array($v[name],$me)){
                        unset($v);
                    }
                    $newMenu[]=$v;
                    $newMenu=array_filter($newMenu);
                }

            }
            /*$rode = $_SESSION['admin']['rode'];
            $before_url = C("URL_BEFORE");
            $a_url = '/requestApi/permission?type=queryPermission&jsonStr={"ZFZH":"'.$ZFZH.'"}';
            $url = $before_url.$a_url;          
            $RR = postHttp($url);*/


            //查询该用户的角色
            /*$role=postHttp(C('URL_BEFORE').'/requestApi/Powers?type=getRoleByZfzh&jsonStr={"zfzh":"'.$ZFZH.'"}');
            $rol=json_decode($role,ture);
            foreach ($rol as $v){
                $role_id=$v[ID];
            }*/
            //p($menu);
            //通过角色id查询功能
            /*$power=postHttp(C('URL_BEFORE').'/requestApi/Powers?type=getFunctionByRolId&jsonStr={"id":"'.$role_id.'"}');
            $powerful=json_decode($power,ture);
            foreach ($powerful as $val){
                $type=explode("_",$val[MARK]);
                if ($type[0]=='road'&&$type[1]=='') {
                    $men = explode("-", $val[NAME]);
                    $me[] = $men[1];
                }
            }
            foreach ($menu as $v){
                if (!in_array($v[name],$me)){
                    unset($v);
                }
                $newMenu[]=$v;
                $newMenu=array_filter($newMenu);
            }*/

//p($_SESSION);

            $this->assign("urc_hy",C("HY"));
            $this->assign("user_name",$ZFZH);

            $this->assign("admin",$c);
            $this->assign("newMenu",$newMenu);
        }
    }

}