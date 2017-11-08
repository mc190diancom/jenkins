<?php
return array(
	//'配置项'=>'配置值'
    TMPL_PARSE_STRING  =>array(

        '__CSS__' => /*'http://10.212.160.180'.*/__ROOT__.'/Public/Common/css', // 更改默认的__PUBLIC__ 替换规则

        '__JS__' => /*'http://10.212.160.180'.*/__ROOT__.'/Public/Common/js', // 增加新的JS类库路径替换规则

        '__IMG__' => /*'http://10.212.160.180'.*/__ROOT__.'/Public/Common/img', // 增加新的上传路径替换规则

        '__JQ__' => /*'http://10.212.160.180'.*/__ROOT__.'/Public/Common',

        '__ROOT__' => /*'http://10.212.160.180'.*/__ROOT__,
    ),
    //接口地址
    //'URL_BEFORE' => '123.57.236.212:8080',
    //'URL_BEFORE' => '10.212.160.180:9876',
    'URL_BEFORE' => '10.212.160.180:9876',
    'URL_LVYOU'=>"http://4404344c.nat123.net:9876/requestApi/lvyou?type=queryWeiFaInfo&jsonStr=",
    'URL_SHENGJI'=>"http://4404344c.nat123.net:9876/requestApi/ShengJi?type=queryWeiFaInfo&jsonStr=" ,
    'URL_HUOYUN'=>"http://4404344c.nat123.net:9876/requestApi/huoyun?type=queryWeiFaInfo&jsonStr=" ,
    'URL_ZULIN'=>"http://4404344c.nat123.net:9876/requestApi/zulin?type=queryWeiFaInfo&jsonStr=" ,

    'MENU'=>array(
        /*array(
            'id'=>'0',
            'name'=>'首页',
            'href'=>__ROOT__."/index.php/Home/Index/index",
        )   ,*/
        array(
            'id'=>'1',
            'name'=>'信息查询',
            'href'=>__ROOT__."/index.php/Home/Message/message_ac",
        ),
        array(
            'id'=>'8',
            'name'=>'执法车辆',
            'href'=>__ROOT__."/index.php/Home/Track/track",
        ) ,
        array(
             'id'=>'3',
             'name'=>'车辆轨迹查询',
             'href'=>__ROOT__."/index.php/Home/Aduit/aduit",
         ),
        array(
            'id'=>'2',
            'name'=>'统计报表',
            'href'=>__ROOT__."/index.php/Home/Statistics/getStatisticsF",
        ),
        
        array(
            'id'=>'4',
            'name'=>'统计图',
            'href'=>__ROOT__."/index.php/Home/Chart/sta_img",
        ),
        /*array(
            'id'=>'5',
            'name'=>'可疑车辆库',
            'href'=>__ROOT__."/index.php/Home/SuspiciousVehicle/Omanagement",
        ),*/
        array(
            'id'=>'6',
            'name'=>'管理员维护',
            'href'=>__ROOT__."/index.php/Home/Admin/Admin_UserList",
        ),

    ),
    /*//行业
    'HY' => array(
            array('name'=>'出租汽车','id'=>'1')
        )*/
    //行业
    'HY' => array(
            array('name'=>'旅游客运','id'=>'1'),
            array('name'=>'省际客运','id'=>'2'),
            array('name'=>'普通货物运输','id'=>'3'),
            array('name'=>'危险品货物运输','id'=>'4'),
            array('name'=>'汽车租赁','id'=>'5')
        )




);