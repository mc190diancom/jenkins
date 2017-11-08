<?php
namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller{

    public function login(){
        if($_COOKIE["ADMIN"]){  
            $mobile = $_COOKIE["ADMIN"]['0'];
            $pwd = $_COOKIE["ADMIN"]['1'];
            $userName = $_COOKIE["ADMIN"]['2'];
            $rode = $_COOKIE["ADMIN"]['3'];
            $pwds = $_COOKIE["ADMIN"]['4'];
            
            $c ['name'] = decode($mobile);
            $c ['pwds'] = decode($pwds);
        }
        $this->assign("admin",$c);
        $this->display("login");
    }

    function ajaxLogin() {
        $mobile = I("mobile");
        $pwd = md5(I("pwd"));
        $pwds = I("pwd");
        $ss = I('ss');//判断是否记住密码
        $before_url = C("URL_BEFORE");
        $a_url = '/requestApi?type=login_new&jsonStr={"userName":"'.$mobile.'","password":"'.$pwd.'"}';
        $url = $before_url.$a_url;
        /*$filename = '111.log';
        $Ts=fopen($filename,"a+");
        fputs($Ts,"\r\n".json_encode ($url));
        fclose($Ts);*/
        $RR =  postHttp($url);
        $R = json_decode($RR,true);

        

        $c['name']  = $mobile;
        $c['pwd']  = $pwd;
        if($R){
            if ($R['err'] == 0) {
                $c['userName'] = $R['userName'];
                $c['rode'] = $R['rode'];
                if($ss == "on"){
                    setcookie('ADMIN[0]',encode($c['name']),time()+3600*24*7, '/', '');
                    setcookie('ADMIN[1]',encode($c['pwd']),time()+3600*24*7, '/', ''); 
                    setcookie('ADMIN[2]',encode($c['userName']),time()+3600*24*7, '/', ''); 
                    setcookie('ADMIN[3]',encode($c['rode']),time()+3600*24*7, '/', '');
                    setcookie('ADMIN[4]',encode($pwds),time()+3600*24*7, '/', '');
                }else{
                    setcookie('ADMIN[0]',encode($c['name']),time()-3600*24*7, '/', '');
                    setcookie('ADMIN[1]',encode($c['pwd']),time()-3600*24*7, '/', ''); 
                    setcookie('ADMIN[2]',encode($c['userName']),time()-3600*24*7, '/', ''); 
                    setcookie('ADMIN[3]',encode($c['rode']),time()-3600*24*7, '/', ''); 
                    setcookie('ADMIN[4]',encode($pwds),time()-3600*24*7, '/', '');
                }
                
                $_SESSION ['admin'] = $c;
                $this->ajaxReturn ( array (
                    "error" => 0
                ));
            } else {
                $this->ajaxReturn ( array (
                    "error" => 1,
                    "errormsg" => $R['errorMsg']
                ));
            }
        }else{
            $this->ajaxReturn ( array (
                    "error" => 1,
                    "errormsg" => "暂时不能登录，请联系管理员"
                ));
        }
        
    }
    function logout(){
        setcookie('ADMIN[0]',"",time()-3600*24*7, '/', '');
        setcookie('ADMIN[1]',"",time()-3600*24*7, '/', '');
        setcookie('ADMIN[2]',"",time()-3600*24*7, '/', '');
        setcookie('ADMIN[3]',"",time()-3600*24*7, '/', '');
        setcookie('ADMIN[4]',"",time()-3600*24*7, '/', '');
        setcookie('ADMIN',"",time()-3600*24*7, '/', '');
        session("admin",null);
        $this->redirect('Login/login');
    }
}