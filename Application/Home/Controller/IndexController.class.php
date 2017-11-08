<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BestController {
    public function index(){
    	$this->assign("check",1);
    	if($_SESSION['admin']['name']){
            $this->assign ( "startDate", date ( 'Y-m-1', strtotime('-1 year') ) . " 00:00:00" );
            $this->assign ( "endDate", date ( 'Y-m-d', time () ) . " 23:59:59" );
            
            $compName =  getCompName();
            //$compName = json_decode($compName);
            // print_r($compName);
            $this->assign("hy",C("HY"));
            $this->assign("compName",$compName);
            $this->assign("check",1);
            $rode = $_SESSION['save'];
            //p($rode);
            //$compName = json_decode($compName);
            // print_r($compName);
            $this->assign("rode",$rode);
    		$this->display('Message/message_ac');
    	}else{
    		$this->redirect('Login/login');
    	}
        
    }
    public function getMessageSearch(){
        $this->display('message_search');
    }
}