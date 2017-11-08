/*
	版权所有 2009-2016 荆门泽优软件有限公司
	保留所有权利
	官方网站：http://www.ncmem.com
	官方博客：http://www.cnblogs.com/xproer
	产品首页：http://www.ncmem.com/webplug/screencapture/
	产品介绍：http://www.cnblogs.com/xproer/archive/2010/08/09/1796077.html
	在线演示-标准版：http://www.ncmem.com/products/screencapture/demo/index.html
	在线演示-专业版：http://www.ncmem.com/products/screencapture/demo2/index.html
	在线演示-FCKEditor2.x：http://www.ncmem.com/products/screencapture/fckeditor2x/index.html
	在线演示-CKEditor3.x：http://www.ncmem.com/products/screencapture/demo-ckeditor361/index_ckeditor361.html
	在线演示-xhEditor1.x：http://www.ncmem.com/products/screencapture/kindeditor3x/index.html
	布署文档：http://www.cnblogs.com/xproer/archive/2011/09/14/2176188.html
	升级日志：http://www.cnblogs.com/xproer/archive/2010/12/04/1896399.html
	开发文档-ASP.NET(C#)：http://www.cnblogs.com/xproer/archive/2010/12/04/1896552.html
	开发文档-PHP：http://www.cnblogs.com/xproer/archive/2011/05/16/2047915.html
	开发文档-JSP：http://www.cnblogs.com/xproer/archive/2011/05/20/2051862.html
	示例下载-标准版：http://yunpan.cn/lk/11mb4zslvk
	示例下载-专业版：http://yunpan.cn/lk/11b1drhnvk
	文档下载：http://yunpan.cn/lk/11pbm5mjvk
	VC运行库：http://www.microsoft.com/downloads/details.aspx?FamilyID=9b2da534-3e03-4391-8a4d-074b9f2bc1bf%20
	联系邮箱：1085617561@qq.com
	联系QQ：1085617561
*/
function debugMsg(txt){$("#msg").append(txt+"<br/>");}
//全局对象
var ScreenCaptureError = {
	  "0": "就绪"
	, "1": "发送数据错误"
	, "2": "接收数据错误"
	, "3": "域名未授权或为空"
	, "4": "公司未授权或为空"
	, "5": "nat app error"
};

var LanguageZhCn = {
      "CapForm": "截屏选择窗口"
    , "CapFormTitle": "选择截屏窗口"
    , "CapFormTip": "请将您想要截取的窗口调整到最前"
    , "BtnOk": "确定"
    , "BtnCancel": "取消"
    , "RectSuze": "区域大小"
    , "CurRGB": "当前RGB"
    , "QuckCap": "双击可以快速完成截图"
};
var LanguageEn = {
      "CapForm": "Capture Form Selecter"
    , "CapFormTitle": "Choose Capture Form"
    , "CapFormTip": "Please set the window to the front which you want to intercept resize"
    , "BtnOk": "Ok"
    , "BtnCancel": "Cancel"
    , "RectSuze": "Rect Size"
    , "CurRGB": "Current RGB"
    , "QuckCap": "Double-click can be quickly completed Screenshot"
};
var LanguageZhTw = {
      "CapForm": "截屏選擇視窗"
    , "CapFormTitle": "選擇截屏視窗"
    , "CapFormTip": "請將您想要截取的視窗調整到最前"
    , "BtnOk": "確定"
    , "BtnCancel": "取消"
    , "RectSuze": "區域大小"
    , "CurRGB": "當前RGB"
    , "QuckCap": "雙擊可以快速完成截圖"
};

/*
	截屏对象管理类，提供常用配置功能
	参数
*/
function CaptureManager()
{
	var _this = this;
	this.StateType = {
		Ready				: 0
		,Posting			: 1
		,Stop				: 2
		,Error				: 3
		,GetNewID			: 4
		,Complete			: 5
		,WaitContinueUpload	: 6
		,None				: 7
		,Waiting			: 8
	};
	_this.State = _this.StateType.None;
	//_this.CaptureDlgID = infDivID;
	this.scpFF = null;
	this.scpIE = null;
	this.scpPnl = null;//面板
	this.scpIco = null;//图标
	this.scpImg = null;//截屏图片显示对象，需要在外部设置(jquery object)
	this.scpMsg = null;//消息
	this.scpPer = null;//百分比
	
	//全局配置信息
	this.Config = {
		  "PostUrl"		: "http://www.ncmem.com/upload.aspx"
		, "EncodeType"	: "utf-8"
		, "Version"		: "1,4,65,31064"
		, "Company"		: "荆门泽优软件有限公司"
		, "License"		: ""
        , "Debug"       : false//是否打开调试模式
        , "LogFile"     : "F:\\log.txt"//日志文件路径
		, "FileFieldName": "img"//自定义图片文件字段名称。
		, "Language"	: "zhcn"//语言设置，en,zhcn,tw
		, "LanCur"	    : LanguageZhCn//语言设置
		, "Quality"     : 100//jpg图片质量，仅对jpg格式有效
		, "ShowForm"	: true//是否显示截屏提示窗口
		, "ImageType"	: "jpg"//图片上传格式。png,jpg,bmp
		, "NameCrypto"	: "crc"//名称生成算法。crc,md5,sha1,uuid
		, "IcoPath"		: "/scp/SL_Uploading.gif"
        , "Cookie"      : ""
        , "Authenticate": { "type": "ntlm", "name": "", "pass": "" }//域环境信息
        //IE(x86)
        , "Clsid"       : "9767D337-E10A-4319-8854-E4B0FB635274"
		, "ProjID"		: "Xproer.ScreenCapturePro2"
		, "CabPath"     : "http://www.ncmem.com/download/ScreenCapturePro2/ScreenCapturePro.cab"
		//IE(x64)
		, "Clsid64"		: "399B59CE-646E-4430-9000-138DF6515306"
		, "ProjID64"	: "Xproer.ScreenCapturePro2x64"
		, "CabPath64"   : "http://www.ncmem.com/download/ScreenCapturePro2/ScreenCapturePro64.cab"
		//FireFox
		, "XpiType"	    : "application/npScpPro2"
		, "XpiPath"     : "http://www.ncmem.com/download/ScreenCapturePro2/ScreenCapturePro.xpi"
		//Chrome
		, "CrxName"		: "npScpPro2"
		, "CrxType"	    : "application/npScpPro2"
		, "CrxPath"     : "http://www.ncmem.com/download/ScreenCapturePro2/ScreenCapturePro.crx"
		, "ExePath"		: "http://www.ncmem.com/download/ScreenCapturePro2/ScreenCapturePro.exe"
	    //Chrome 45
        , "NatHostName" : "com.xproer.scppro"//
		, "ExePath"		: "http://www.ncmem.com/download/ScreenCapturePro2/ScreenCapturePro.exe"
	};
	
	//附加对象
	this.Fields = {
		 "uname": "test"
		,"upass": "test"
	};

	this.postError = function (json)
	{
	    this.scpMsg.text(ScreenCaptureError[json.value]);
	    this.scpPer.text("");
	};
	this.postProcess = function (json)
	{
	    this.scpPer.text(json.percent);
	};
	this.postComplete = function (json)
	{
	    this.scpPer.text("100%");
	    this.scpMsg.text("上传完成");
	    this.CloseMsg(); //隐藏信息层
	    //显示截取的屏幕图片
	    this.scpImg.attr("src", json.value);
	    this.scpImg.css("display", "block");
	};
	this.runComplete = function (json)
	{
	    this.Browser.exitCheck();
	};
	this.afterCapture = function (json) { this.OpenMsg();/*打开信息面板*/ };
	this.recvMessage = function (str)
	{
	    var json = JSON.parse(str);
	    if      (json.name == "AfterCapture") { _this.afterCapture(json); }
	    else if (json.name == "post_process") { _this.postProcess(json); }
	    else if (json.name == "post_error") { _this.postError(json); }
	    else if (json.name == "post_complete") { _this.postComplete(json); }
	    else if (json.name == "run_complete") { _this.runComplete(json); }
	    else if (json.name == "run_error") { _this.postError(json); }
	};

    //IE浏览器信息管理对象
	_this.BrowserIE = {
	    "GetHtml": function ()
	    {
	        /*ActiveX的静态加载方式，如果在框架页面中使用此控件，推荐使用静态加截方式。
			<object id="objScreenCapture" classid="clsid:B10327CB-56EC-43D9-BED0-C91E4AE8F42E" codebase="http://www.ncmem.com/products/screencapture/demo/ScreenCapture.cab#version=1,6,26,54978" width="1" height="1"></object>
			*/
	        var acx = '<div style="display: none">';
	        acx += '<object id="objScreenCapture" classid="clsid:' + _this.Config["Clsid"] + '"';
	        acx += ' codebase="' + _this.Config["CabPath"] + '#version=' + _this.Config["Version"] + '" width="1" height="1"></object>';
	        acx += '</div>';
	        return acx;
	    }//检查插件是否已安装
		, "Check": function ()
		{
		    try
		    {
		        var com = new ActiveXObject(_this.Config["ProjID"]);
		        return true;
		    }
		    catch (e) { return false; }
		}
        , "Init": function ()
        {
            var param = { config: _this.Config, fields: _this.Fields };
            _this.scpIE.Init(JSON.stringify(param));
            _this.scpIE.StateChanged = _this.recvMessage;
        }
        , "Capture": function () { _this.scpIE.Capture(); }
        , "CaptureScreen": function () { _this.scpIE.CaptureScreen(); }
        , "CaptureRect": function (x, y, w, h)
        {
            var par = { "x": x, "y": y, "w": w, "h": h };
            _this.scpIE.CaptureRect(JSON.stringify(par));
        }
        , "exitCheck": function () { }
	};
	//FireFox浏览器信息管理对象
	_this.BrowserFF = {
		"GetHtml": function ()
		{
			var html = '<embed type="' + _this.Config["XpiType"] + '" pluginspage="' + _this.Config["XpiPath"] + '" width="1" height="1" id="objScreenCapture">';
			return html;
		}
		, "GetPlugin": function ()
		{
		    return this.plugin;
		} //检查插件是否已安装
		, "Check": function ()
		{
		    var mimetype = navigator.mimeTypes;
		    if (typeof mimetype == "object" && mimetype.length)
		    {
		        for (var i = 0; i < mimetype.length; i++)
		        {
		            if (mimetype[i].type == _this.Config["XpiType"].toLowerCase())
		            {
		                return mimetype[i].enabledPlugin;
		            }
		        }
		    }
		    else
		    {
		        mimetype = [_this.Config["XpiType"]];
		    }
		    if (mimetype)
		    {
		        return mimetype.enabledPlugin;
		    }
		    return false;
		} //安装插件
		, "Setup": function ()
		{
			var xpi = new Object();
			xpi["Calendar"] = _this.Config["XpiPath"];
			InstallTrigger.install(xpi, function (name, result) { });
		}
        , "Init": function ()
        {
            var param = { config: _this.Config, fields: _this.Fields };
            _this.scpFF.Init(JSON.stringify(param));
            _this.scpFF.StateChanged = _this.recvMessage;
        }
        , "Capture": function () { _this.scpFF.Capture(); }
        , "CaptureScreen": function () { _this.scpFF.CaptureScreen(); }
        , "CaptureRect": function (x, y, w, h)
        {
            var par = { "x": x, "y": y, "w": w, "h": h };
            _this.scpFF.CaptureRect(JSON.stringify(par));
        }
        , "exitCheck": function () { }
	};
	//Chrome浏览器信息管理对象
	_this.BrowserChr =
	{
		"GetHtml": function()
		{
			var html = '<embed type="' + _this.Config["CrxType"] + '" pluginspage="' + _this.Config["CrxPath"] + '" width="1" height="1" id="objScreenCapture">';
			return html;
		}
		, "GetPlugin": function()
		{
		    return this.plugin;
		    
		} //检查插件是否已安装
		, "Check": function()
		{
			for (var i = 0, l = navigator.plugins.length; i < l; i++)
			{
				if (navigator.plugins[i].name == _this.Config["CrxName"])
				{
					return true;
				}
			}
			return false;
		} //安装插件
		, "Setup": function()
		{
		    document.write('<iframe style="display:none;" src="' + _this.Config["CrxPath"] + '"></iframe>');
		    //chrome.webstore.install(_this.Config["CabPath"], function(){alert("安装成功，请刷新页面")}, function(){alert("安装失败，请检查插件地址是否正确")})
		}
        , "Init": function ()
        {
            var param = { config: _this.Config, fields: _this.Fields };
            _this.scpFF.Init(JSON.stringify(param));
            _this.scpFF.StateChanged = _this.recvMessage;
        }
        , "Capture": function () { _this.scpFF.Capture(); }
        , "CaptureScreen": function () { _this.scpFF.CaptureScreen(); }
        , "CaptureRect": function (x, y, w, h)
        {
            var par = { "x": x, "y": y, "w": w, "h": h };
            _this.scpFF.CaptureRect(JSON.stringify(par));
        }
        , "exitCheck": function () { }
	};
    //Chrome 45+ (Native Message)
	_this.BrowserNat = {
          "Check": function () { return true; }
        , "Setup": function () { }
        , "entID": "ScpProEvent"
        , "Init": function ()
        {
            document.addEventListener('ScpProEventCallBack', function (evt)
            {
                _this.recvMessage(JSON.stringify( evt.detail));
            });
        }
        , "Capture": function ()
        {
            var par = { name: 'Capture', config: _this.Config, fields: _this.Fields };
            var evt = document.createEvent("CustomEvent");
            evt.initCustomEvent(this.entID, true, false, par);
            document.dispatchEvent(evt);
        }
        , "CaptureRect": function (left, top, width, height)
        {
            var par = { name: 'CaptureRect', x: left, y: top, w: width, h: height, config: _this.Config, fields: _this.Fields };
            var evt = document.createEvent("CustomEvent");
            evt.initCustomEvent(this.entID, true, false, par);
            document.dispatchEvent(evt);
        }
        , "CaptureScreen": function ()
        {
            var par = { name: 'CaptureScreen', config: _this.Config, fields: _this.Fields };
            var evt = document.createEvent("CustomEvent");
            evt.initCustomEvent(this.entID, true, false, par);
            document.dispatchEvent(evt);
        }
        , "exit": function ()
        {
            var par = { name: 'exit'};
            var evt = document.createEvent("CustomEvent");
            evt.initCustomEvent(this.entID, true, false, par);
            document.dispatchEvent(evt);
        }
        , "exitCheck": function ()
        {
            var obj = this;
            $(window).bind("beforeunload", function () { obj.exit(); });
        }
	};
	_this.Browser = _this.BrowserIE;
	var browserName = navigator.userAgent.toLowerCase();
	this.ie = browserName.indexOf("msie") > 0;
	//IE11
	this.ie = _this.ie ? _this.ie : browserName.search(/(msie\s|trident.*rv:)([\w.]+)/)!=-1;
	this.firefox = browserName.indexOf("firefox") > 0;
	this.chrome = browserName.indexOf("chrome") > 0;
	this.chrome45 = false;
	this.chrVer = navigator.appVersion.match(/Chrome\/(\d+)/);

	if ( this.ie)
	{
		//Win64
		if (window.navigator.platform == "Win64")
		{
			this.Config["Clsid"] = this.Config["Clsid64"];
			this.Config["ProjID"] = this.Config["ProjID64"];
			this.Config["CabPath"] = this.Config["CabPath64"];
		}
	} //Firefox
	else if (this.firefox)
	{
		_this.Browser = this.BrowserFF;
	} //chrome
	else if (this.chrome)
	{
	    this.Config["XpiType"] = this.Config["CrxType"];
	    this.Config["XpiPath"] = this.Config["CrxPath"];
	    _this.Browser = this.BrowserChr;
	    //44+版本使用Native Message
	    if (parseInt(this.chrVer[1]) >= 44)
	    {
            //部分基于Chrome 45浏览器仍然使用npapi
	        if (!this.BrowserChr.Check())
	        {
	            _this.chrome45 = true;//
	            _this.Browser = this.BrowserNat;
	        }
	    }
	}

	this.GetHtml = function ()
	{
        //ff
	    var html = "";
	    if(!_this.chrome45) html += '<embed name="scpFF" type="' + this.Config["XpiType"] + '" pluginspage="' + this.Config["XpiPath"] + '" width="1" height="1">';
        //ie
	    //html += '<div style="display: none">';
	    html += '<object name="scpIE" classid="clsid:' + this.Config["Clsid"] + '"';
	    html += ' codebase="' + this.Config["CabPath"] + '#version=' + this.Config["Version"] + '" width="1" height="1"></object>';
	    //html += '</div>';
	    //
	    html += '<div name="pnl" class="scpPanel">\
	                <img name="ico" alt="进度图标" src="/ScreenCapture/process.gif" /><span name="msg">图片上传中...</span><span name="per">10%</span>\
	            </div>';
	    return html;
	};

    //加载到document.body中
	this.Load = function()
	{
	    var ui = $(document.body).append(this.GetHtml());
	    this.scpFF  = ui.find('embed[name="scpFF"]').get(0);
	    this.scpIE  = ui.find('object[name="scpIE"]').get(0);
	    this.scpPnl = ui.find('div[name="pnl"]');
	    this.scpIco = ui.find('img[name="ico"]').attr("src",this.Config["IcoPath"]);
	    this.scpMsg = ui.find('span[name="msg"]');
	    this.scpPer = ui.find('span[name="per"]');

	    this.Browser.Init();
	};
	
	//加截到指定对象内部
	this.LoadTo = function(oid)
	{
	    var ui = $("#" + oid).append(this.GetHtml());
	    this.scpFF  = ui.find('embed[name="scpFF"]').get(0);
	    this.scpIE  = ui.find('object[name="scpIE"]').get(0);
	    this.scpPnl = ui.find('div[name="pnl"]');
	    this.scpIco = ui.find('img[name="ico"]').attr("src",this.Config["IcoPath"]);
	    this.scpMsg = ui.find('span[name="msg"]');
	    this.scpPer = ui.find('span[name="per"]');

	    this.Browser.Init();
	};

	//截屏函数
	this.Capture = function()
	{
	    this.Browser.Capture();
	};
	
	//截取整个屏幕
	this.CaptureScreen = function()
	{
	    this.Browser.CaptureScreen();
	};

	//截取指定区域
	this.CaptureRect = function(x,y,w,h)
	{
	    this.Browser.CaptureRect(x, y, w, h);
	};

	this.OpenMsg = function()
	{
	    _this.scpPnl.css("display", "block");
	    _this.scpMsg.text("图片上传中...");
	};

	this.CloseMsg = function()
	{
	    _this.scpPnl.css("display", "none"); //隐藏信息层
	};
}