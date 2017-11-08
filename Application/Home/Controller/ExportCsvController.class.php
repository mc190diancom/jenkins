<?php
namespace Home\Controller;

namespace Home\Controller;
use Think\Controller;

class ExportCsvController extends Controller{
    

    /**
     * 出租汽车稽查记录查询
     */
    function AuditingAllList(){
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
        ////requestApi/bs_Taxi?type=AuditingAllList&jsonStr={"driverName":"","cyzg":"","vName":"","startTime":"1471000000","endTime":"1481446000","dd":"","zd":"","cz":"","num":"","corpName":""}
        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=AuditingAllList&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $R2 = $R['rows'];
        //p($R2);
        
        //稽查编号,车牌号码,所属单位（车辆）,驾驶员姓名,所属单位（驾驶员）,企业名称,执法人员1,执法人员2,大队,中队,车组,稽查时间,稽查地点,稽查行业,稽查结果
        for ($i=0; $i < count($R['rows']); $i++) { 
            $Res[$i]['JCBH'] = $R2[$i]['JCBH'];//稽查编号
            $Res[$i]['VNAME'] = $R2[$i]['VNAME'];//车牌号码
            $Res[$i]['CORPNAME'] = $R2[$i]['CORPNAME'];//所属单位（车辆）
            $Res[$i]['DRIVERNAME'] = $R2[$i]['DRIVERNAME'];//驾驶员姓名
            $Res[$i]['rcomp'] = $R2[$i]['rcomp'];//所属单位（驾驶员）
            $Res[$i]['vcomp'] = $R2[$i]['vcomp'];//企业名称
            $Res[$i]['ZFRY1'] = $R2[$i]['ZFRY1'];//执法人员1
            $Res[$i]['ZFRY2'] = $R2[$i]['ZFRY2'];//执法人员2
            $Res[$i]['ZFDWMC'] = $R2[$i]['ZFDWMC'];//大队
            $Res[$i]['SSZD'] = $R2[$i]['SSZD'];//中队
            $Res[$i]['SSCZ'] = $R2[$i]['SSCZ'];//车组
            $Res[$i]['ZFSJ'] = date('Y-m-d H:i:s',$R2[$i]['ZFSJ']);//稽查时间
            $Res[$i]['ADDRESS'] = $R2[$i]['ADDRESS'];//稽查地点
            $Res[$i]['HYLB'] = $R2[$i]['HYLB'];//稽查行业
            $Res[$i]['STATUS'] = $R2[$i]['STATUS'];//稽查结果
        }
        

        //数据处理
        ///////////////////////////////

        header('Content-Type: application/vnd.ms-excel'); 
        $filename = '出租汽车稽查记录'.date('_YmdHis').'.csv';
        $filename = urlencode($filename);
        $filename = iconv('utf-8', 'gbk', $filename);
        header('Content-Disposition: attachment;filename='.$filename); 
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output', 'a');

        // 输出Excel列名信息
        $head = array('稽查编号','车牌号码','所属单位（车辆）','驾驶员姓名','所属单位（驾驶员）','企业名称','执法人员1','执法人员2','大队','中队','车组','稽查时间','稽查地点','稽查行业','稽查结果');
        
        foreach ($head as $key => $value) {
            $head[$key] = iconv('utf-8', 'gbk', $value);
        }
        
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        // 将数据通过fputcsv写到文件句柄
        fputcsv($fp, $head);

        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 10000;

        
        
        $xlsData  = $Res;//数据

      /* p($xlsData);
        die;*/
        
       // 逐行取出数据，不浪费内存
        $count = count($xlsData);

      for($t=0;$t<$count;$t++) {

            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            $row[] = $xlsData[$t];
          
            foreach ($row as $i => $v) {
                $v['JCBH'] = addT($v['JCBH']);
                foreach ($v as $key => $value) {
                    $v[$key] = iconv('utf-8', 'gbk',$value);
                }
                //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($fp, $v);
                unset($v);
            }
            unset($row);
        }
    }
    
    /**
     * 车组执法稽查数量统计表
     */
    function CzLawAllList(){
        $hylb = I('hy');//行业
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间
      
        if($hylb != '全部'){
            $c['hylb'] = $hylb;
        }else{
            $c['hylb'] = '';
        }
        
        $c['startTime'] = strtotime($startTime);
        $c['endTime'] = strtotime($endTime);

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=CzLawAllList&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $R2 = $R['rows'];
       
      
        for ($i=0; $i < count($R2); $i++) { 
            $Res[$i]['id'] = $i+1;
            $Res[$i]['ZFDWMC'] = $R2[$i]['ZFDWMC'];
            $Res[$i]['SSZD'] = $R2[$i]['SSZD'];
            $Res[$i]['SSCZ'] = $R2[$i]['SSCZ'];
            $Res[$i]['ZFRY1'] = $R2[$i]['ZFRY1'];
            $Res[$i]['ZFRY2'] = $R2[$i]['ZFRY2'];//
            $Res[$i]['STAT0'] = $R2[$i]['STAT0'];//
            $Res[$i]['STAT2'] = $R2[$i]['STAT2'];//
            $Res[$i]['STAT3'] = $R2[$i]['STAT3'];//
            $Res[$i]['STAT4'] = $R2[$i]['STAT4'];//
            $Res[$i]['STAT5'] = $R2[$i]['STAT5'];//
            $Res[$i]['count'] = $R2[$i]['STAT0']+$R2[$i]['STAT2']+$R2[$i]['STAT3']+$R2[$i]['STAT4']+$R2[$i]['STAT5'];//
        }
         

        //数据处理
        ///////////////////////////////

        header('Content-Type: application/vnd.ms-excel'); 
        $filename = '车组执法稽查数量统计表'.date('_YmdHis').'.csv';
        $filename = urlencode($filename);
        $filename = iconv('utf-8', 'gbk', $filename);
        header('Content-Disposition: attachment;filename='.$filename); 
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output', 'a');

        // 输出Excel列名信息
        $head = array('序号','单位','中队','车组','执法人员1','执法人员2','表扬','正常','批教','警告','处罚','总计');
        
        foreach ($head as $key => $value) {
            $head[$key] = iconv('utf-8', 'gbk', $value);
        }
        
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        // 将数据通过fputcsv写到文件句柄
        fputcsv($fp, $head);

        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 10000;

        
        
        $xlsData  = $Res;//数据

      /* p($xlsData);
        die;*/
        
       // 逐行取出数据，不浪费内存
        $count = count($xlsData);

      for($t=0;$t<$count;$t++) {

            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            $row[] = $xlsData[$t];
          
            foreach ($row as $i => $v) {
                foreach ($v as $key => $value) {
                    $v[$key] = iconv('utf-8', 'gbk',$value);
                }
                //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($fp, $v);
                unset($v);
            }
            unset($row);
        }
    }

    /**
     * 大队执法稽查数量统计表
     */
    function DdLawAllList(){
        $hylb = I('hy');//行业
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间
      
        if($hylb != '全部'){
            $c['hylb'] = $hylb;
        }else{
            $c['hylb'] = '';
        }
        
        $c['startTime'] = strtotime($startTime);
        $c['endTime'] = strtotime($endTime);

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=DdLawAllList&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);
        $R2 = $R['rows'];
       
      
        for ($i=0; $i < count($R2); $i++) { 
            $Res[$i]['id'] = $i+1;
            $Res[$i]['ZFDWMC'] = $R2[$i]['ZFDWMC'];
            /*$Res[$i]['ZFRY1'] = $R2[$i]['ZFRY1'];
            $Res[$i]['ZFRY2'] = $R2[$i]['ZFRY2'];//*/
            $Res[$i]['STAT0'] = $R2[$i]['STAT0'];//
            $Res[$i]['STAT2'] = $R2[$i]['STAT2'];//
            $Res[$i]['STAT3'] = $R2[$i]['STAT3'];//
            $Res[$i]['STAT4'] = $R2[$i]['STAT4'];//
            $Res[$i]['STAT5'] = $R2[$i]['STAT5'];//
            $Res[$i]['count'] = $R2[$i]['STAT0']+$R2[$i]['STAT2']+$R2[$i]['STAT3']+$R2[$i]['STAT4']+$R2[$i]['STAT5'];//
        }
         

        //数据处理
        ///////////////////////////////

        header('Content-Type: application/vnd.ms-excel'); 
        $filename = '大队执法稽查数量统计表'.date('_YmdHis').'.csv';
        $filename = urlencode($filename);
        $filename = iconv('utf-8', 'gbk', $filename);
        header('Content-Disposition: attachment;filename='.$filename); 
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output', 'a');

        // 输出Excel列名信息
        $head = array('序号','单位','表扬','正常','批教','警告','处罚','总计');
        
        foreach ($head as $key => $value) {
            $head[$key] = iconv('utf-8', 'gbk', $value);
        }
        
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        // 将数据通过fputcsv写到文件句柄
        fputcsv($fp, $head);

        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 10000;

        
        
        $xlsData  = $Res;//数据

      /* p($xlsData);
        die;*/
        
       // 逐行取出数据，不浪费内存
        $count = count($xlsData);

      for($t=0;$t<$count;$t++) {

            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            $row[] = $xlsData[$t];
          
            foreach ($row as $i => $v) {
                foreach ($v as $key => $value) {
                    $v[$key] = iconv('utf-8', 'gbk',$value);
                }
                //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($fp, $v);
                unset($v);
            }
            unset($row);
        }
    }



    /**
     * 用户列表
     */
    function UserAllList(){
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

        //{"zfzh":"0000000","name":"貂蝉","sex":"女","dd":"北京市交通执法总队第五执法大队","startIndex":0,"endIndex":5}

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=UserAllList&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        /*p($R);
        die;*/
       
        $R2 = $R['rows'];

        for ($i=0; $i < count($R2); $i++) { 
            $Res[$i]['ZFZH'] = $R2[$i]['ZFZH'];
            $Res[$i]['NAME'] = $R2[$i]['NAME'];//
            $Res[$i]['SEX'] = $R2[$i]['SEX'];//
            $Res[$i]['ZFDWMC'] = $R2[$i]['ZFDWMC'];//
            $Res[$i]['LASTLOGIN'] = date("Y年m月d日",($R2[$i]['LASTLOGIN']/1000));//
            if($R2[$i]['ZHZT'] ==1){
                $Res[$i]['ZHZT'] = '启用';
            }else{
                $Res[$i]['ZHZT'] = '禁用';
            }
            
        }
         

        //数据处理
        ///////////////////////////////

        header('Content-Type: application/vnd.ms-excel'); 
        $filename = '用户列表'.date('_YmdHis').'.csv';
        $filename = urlencode($filename);
        $filename = iconv('utf-8', 'gbk', $filename);
        header('Content-Disposition: attachment;filename='.$filename); 
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output', 'a');

        // 输出Excel列名信息
        $head = array('账号','姓名','性别','组织','最后登陆日期','启用与否');
        
        foreach ($head as $key => $value) {
            $head[$key] = iconv('utf-8', 'gbk', $value);
        }
        
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        // 将数据通过fputcsv写到文件句柄
        fputcsv($fp, $head);

        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 10000;

        
        
        $xlsData  = $Res;//数据

      /* p($xlsData);
        die;*/
        
       // 逐行取出数据，不浪费内存
        $count = count($xlsData);

      for($t=0;$t<$count;$t++) {

            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            $row[] = $xlsData[$t];
          
            foreach ($row as $i => $v) {
                foreach ($v as $key => $value) {
                    $v[$key] = iconv('utf-8', 'gbk',$value);
                }
                //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($fp, $v);
                unset($v);
            }
            unset($row);
        }
    }


    /**
     * 出租汽车业内违规数量查询
     */
    function ViolationsAllList(){
        $dd = I('dd');//大队
        $zd = I('zd');//中队
        $cz = I('cz');//车组
        $startTime = I('startTime');//起始时间
        $endTime = I('endTime');//结束时间

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

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=ViolationsAllList&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        /*p($R);
        die;*/
       
        $R2 = $R['rows'];
        //大队,车组,01服务,02车容仪表,04牌证标志,05绕路,06人车不符,07拒载,08议价多收费
        for ($i=0; $i < count($R2); $i++) { 
            $Res[$i]['ZFDWMC'] = $R2[$i]['ZFDWMC'];
            $Res[$i]['SSZD'] = $R2[$i]['SSZD'];//
            $Res[$i]['SSCZ'] = $R2[$i]['SSCZ'];//
            $Res[$i]['FW'] = $R2[$i]['FW'];// 
            $Res[$i]['CRYB'] = $R2[$i]['CRYB'];//
            $Res[$i]['PZBZ'] = $R2[$i]['PZBZ'];//
            $Res[$i]['RL'] = $R2[$i]['RL'];//
            $Res[$i]['RCBF'] = $R2[$i]['RCBF'];//
            $Res[$i]['JZ'] = $R2[$i]['JZ'];//
            $Res[$i]['YJDSF'] = $R2[$i]['YJDSF'];//
            
        }
         

        //数据处理
        ///////////////////////////////

        header('Content-Type: application/vnd.ms-excel'); 
        $filename = '出租汽车业内违规'.date('_YmdHis').'.csv';
        $filename = urlencode($filename);
        $filename = iconv('utf-8', 'gbk', $filename);
        header('Content-Disposition: attachment;filename='.$filename); 
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output', 'a');

        // 输出Excel列名信息
        $head = array('大队','车组','01服务','02车容仪表','04牌证标志','05绕路','06人车不符','07拒载','08议价多收费');
        
        foreach ($head as $key => $value) {
            $head[$key] = iconv('utf-8', 'gbk', $value);
        }
        
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        // 将数据通过fputcsv写到文件句柄
        fputcsv($fp, $head);

        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 10000;

        
        
        $xlsData  = $Res;//数据

      /* p($xlsData);
        die;*/
        
       // 逐行取出数据，不浪费内存
        $count = count($xlsData);

      for($t=0;$t<$count;$t++) {

            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            $row[] = $xlsData[$t];
          
            foreach ($row as $i => $v) {
                foreach ($v as $key => $value) {
                    $v[$key] = iconv('utf-8', 'gbk',$value);
                }
                //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($fp, $v);
                unset($v);
            }
            unset($row);
        }
    }

    /**
     * 检查项维护
     */
    function checkMaintainAll(){
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

        $arr_json = json_encode($c);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=checkMaintainAll&jsonStr=".$arr_json);
        $R = json_decode($R_json,true);

        /*p($R);
        die;*/
       
        $R2 = $R['rows'];
        //行业,被检查主体,检查类别,代码,检查结果,违法行为,法规依据,依据条款,处罚条款,法规规定
        for ($i=0; $i < count($R2); $i++) { 
            $Res[$i]['HYLB'] = $R2[$i]['HYLB'];
            $Res[$i]['BJCZT'] = $R2[$i]['BJCZT'];//
            $Res[$i]['JCLB'] = $R2[$i]['JCLB'];//
            $Res[$i]['BM'] = $R2[$i]['BM'];// 
            $Res[$i]['JCJG'] = $R2[$i]['JCJG'];//
            $Res[$i]['WFXW'] = $R2[$i]['WFXW'];//
            $Res[$i]['WFYJ'] = $R2[$i]['WFYJ'];//
            $Res[$i]['YJTK'] = $R2[$i]['YJTK'];//
            $Res[$i]['CFTK'] = $R2[$i]['CFTK'];//
            $Res[$i]['FGGD'] = $R2[$i]['FGGD'];//
            
        }
         

        //数据处理
        ///////////////////////////////

        header('Content-Type: application/vnd.ms-excel'); 
        $filename = '检查项维护'.date('_YmdHis').'.csv';
        $filename = urlencode($filename);
        $filename = iconv('utf-8', 'gbk', $filename);
        header('Content-Disposition: attachment;filename='.$filename); 
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output', 'a');

        // 输出Excel列名信息
        $head = array('行业','被检查主体','检查类别','代码','检查结果','违法行为','法规依据','依据条款','处罚条款','法规规定');
        
        foreach ($head as $key => $value) {
            $head[$key] = iconv('utf-8', 'gbk', $value);
        }
        
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        // 将数据通过fputcsv写到文件句柄
        fputcsv($fp, $head);

        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 10000;

        
        
        $xlsData  = $Res;//数据

      /* p($xlsData);
        die;*/
        
       // 逐行取出数据，不浪费内存
        $count = count($xlsData);

      for($t=0;$t<$count;$t++) {

            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            $row[] = $xlsData[$t];
          
            foreach ($row as $i => $v) {
                foreach ($v as $key => $value) {
                    $v[$key] = iconv('utf-8', 'gbk',$value);
                }
                //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($fp, $v);
                unset($v);
            }
            unset($row);
        }
    }

    function SuspiciousVehicleAll(){
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


        $arr_json = json_encode($c);
        $arr_json = str_replace(' ','%20',$arr_json);
        $R_json = postHttp(C("URL_BEFORE")."/requestApi/bs_Taxi?type=SuspiciousVehicleAll&jsonStr=".$arr_json);

        $R = json_decode($R_json,true);

        $R2 = $R['rows'];
        //p($R2);die;
        //可疑库类型,车牌号码,人员姓名,人员身份证号,人员准驾证号,业户名称,有效标志,入库时间,入库说明,可疑项节点代码列表,案底库的违法行为,车辆ID,业户ID,人员ID,创建时间,更新时间
        for ($i=0; $i < count($R2); $i++) { 
            $Res[$i]['KYK_LX'] = $R2[$i]['KYK_LX'];//可疑库类型
            $Res[$i]['CPH'] = $R2[$i]['CPH'];//车牌号码
            $Res[$i]['RY_MC'] = $R2[$i]['RY_MC'];//人员姓名
            $Res[$i]['RY_SFZH'] = $R2[$i]['RY_SFZH'];//人员身份证号 
            $Res[$i]['RY_ZJZH'] = $R2[$i]['RY_ZJZH'];//人员准驾证号
            $Res[$i]['YH_MC'] = $R2[$i]['YH_MC'];//业户名称
            $Res[$i]['YXBZ'] = $R2[$i]['YXBZ'];//有效标志
            $Res[$i]['RKSJ'] = date('Y-m-d H:i:s',$R2[$i]['RKSJ']/1000);//入库时间
            $Res[$i]['RKSM'] = $R2[$i]['RKSM'];//入库说明
            $Res[$i]['KYX_BMS'] = $R2[$i]['KYX_BMS'];//可疑项节点代码列表
            $Res[$i]['ADK_WFXW'] = $R2[$i]['ADK_WFXW'];
            $Res[$i]['CL_ID'] = $R2[$i]['CL_ID'];
            $Res[$i]['YH_ID'] = $R2[$i]['YH_ID'];
            $Res[$i]['RY_ID'] = $R2[$i]['RY_ID'];
            $Res[$i]['CREATE_DATE'] = date('Y-m-d H:i:s',$R2[$i]['CREATE_DATE']/1000);
            $Res[$i]['UPDATE_DATE'] = date('Y-m-d H:i:s',$R2[$i]['UPDATE_DATE']/1000);
            
        }
         

        //数据处理
        ///////////////////////////////

        header('Content-Type: application/vnd.ms-excel'); 
        $filename = '可疑车辆库管理'.date('_YmdHis').'.csv';
        $filename = urlencode($filename);
        $filename = iconv('utf-8', 'gbk', $filename);
        header('Content-Disposition: attachment;filename='.$filename); 
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output', 'a');

        // 输出Excel列名信息
        $head = array('可疑库类型','车牌号码','人员姓名','人员身份证号','人员准驾证号','业户名称','有效标志','入库时间','入库说明','可疑项节点代码列表','案底库的违法行为','车辆ID','业户ID','人员ID','创建时间','更新时间');
        
        foreach ($head as $key => $value) {
            $head[$key] = iconv('utf-8', 'gbk', $value);
        }
        
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        // 将数据通过fputcsv写到文件句柄
        fputcsv($fp, $head);

        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 10000;

        
        
        $xlsData  = $Res;//数据

      /* p($xlsData);
        die;*/
        
       // 逐行取出数据，不浪费内存
        $count = count($xlsData);

      for($t=0;$t<$count;$t++) {

            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            $row[] = $xlsData[$t];
          
            foreach ($row as $i => $v) {
                $v['RY_SFZH'] = addT($v['RY_SFZH']);
                foreach ($v as $key => $value) {
                    $v[$key] = iconv('utf-8', 'gbk',$value);
                }
                //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($fp, $v);
                unset($v);
            }
            unset($row);
        }
    }

    /**
     * 道路运输执法记录查询
     */
    function get_Register_All(){

        $c['totalNum'] = 0;
        $c['vname'] = I('vName');//车牌号码
        $c['driverName'] = I('driverName');//姓名
        $c['corpName'] = I('corpName');//公司名称
        $c['cyzgz'] = I('cyzg');//从业资格证
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
        $c['code'] = '';
        $c['jdkh'] = '';
        

        $R2_json = json_encode($c);
       
        $R2_json =  postHttp(C("URL_BEFORE")."/requestApi/xinxi?type=get_Register_All&jsonStr=".$R2_json);
        $R2 = json_decode($R2_json,true);
        /*p($R2);
        die;*/
        //'稽查人员','大队','创建时间','从业资格证','公司名称','车牌号码','驾驶员姓名','行业'
        for ($i=0; $i < count($R2); $i++) { 
            $Res[$i]['ZFRY1'] = $R2[$i]['ZFRY1'];//稽查人员
            $Res[$i]['ZFDWMC'] = $R2[$i]['ZFDWMC'];//大队
            $Res[$i]['ZFSJ'] = date('Y-m-d H:i:s',$R2[$i]['ZFSJ']) ;//创建时间
            $Res[$i]['JDKH'] = $R2[$i]['JDKH'];//从业资格证
            $Res[$i]['CORPNAME'] = $R2[$i]['CORPNAME'];//公司名称
            $Res[$i]['VNAME'] = $R2[$i]['VNAME'];//车牌号码
            $Res[$i]['DRIVERNAME'] = $R2[$i]['DRIVERNAME'];//驾驶员姓名
            $Res[$i]['HYLB'] = $R2[$i]['HYLB'];//行业
            
        }
         

        //数据处理
        ///////////////////////////////

        header('Content-Type: application/vnd.ms-excel'); 
        $filename = '道路运输执法记录'.date('_YmdHis').'.csv';
        $filename = urlencode($filename);
        $filename = iconv('utf-8', 'gbk', $filename);
        header('Content-Disposition: attachment;filename='.$filename); 
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output', 'a');

        // 输出Excel列名信息
        $head = array('稽查人员','大队','创建时间','从业资格证','公司名称','车牌号码','驾驶员姓名','行业');
        
        foreach ($head as $key => $value) {
            $head[$key] = iconv('utf-8', 'gbk', $value);
        }
        
        //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        // 将数据通过fputcsv写到文件句柄
        fputcsv($fp, $head);

        // 计数器
        $cnt = 0;
        // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 10000;

        
        
        $xlsData  = $Res;//数据

      /* p($xlsData);
        die;*/
        
       // 逐行取出数据，不浪费内存
        $count = count($xlsData);

      for($t=0;$t<$count;$t++) {

            $cnt ++;
            if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
                ob_flush();
                flush();
                $cnt = 0;
            }
            $row[] = $xlsData[$t];
          
            foreach ($row as $i => $v) {
                $v['RY_SFZH'] = addT($v['RY_SFZH']);
                foreach ($v as $key => $value) {
                    $v[$key] = iconv('utf-8', 'gbk',$value);
                }
                //fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($fp, $v);
                unset($v);
            }
            unset($row);
        }
    }

        
}


