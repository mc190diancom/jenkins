/**
 * 
 */
var _page = self; //当前页面
var win = null; //弹出窗口
var winBody=null;//弹出窗口内部body
var ifr = null;//弹出窗口内部iframe

////弹出窗口回调函数
function closeWin(){
	if(win!=null){
		win.window('close');
	}
}
function openWin(){
	if(win!=null){
		win.window('open');
	}
}
function destroyWin(){
	if(win!=null){
		win.window('destroy');
	}
}

function openDialog(config){
	winBody = $('<div style="overflow: hidden;" closed="true"></div>');
	ifr =$('<iframe width="100%" height="100%" frameborder="0" src="'+config.url+'" ></iframe>');
	winBody.append(ifr);
	top.window.$('body').append(winBody);  
	win=winBody.dialog(config)   
	win.window('open');
}

//根据日期计算年龄
function calAge(_date){
	if(_date == undefined){
		return "";
	}
	var birthday=new Date(_date.replace(/-/g, "\/"));   
	var d=new Date();   
	var age = d.getFullYear()-birthday.getFullYear()-((d.getMonth()<birthday.getMonth()|| d.getMonth()==birthday.getMonth() && d.getDate()<birthday.getDate())?1:0);
	return age;
}

