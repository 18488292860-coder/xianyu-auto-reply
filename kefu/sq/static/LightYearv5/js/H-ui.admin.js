/* -----------H-ui前端框架-------------
* H-ui.admin.js v3.1
* http://www.h-ui.net/
* Created & Modified by guojunhui
* Date modified 2017.02.03
* Copyright 2013-2017 北京颖杰联创科技有限公司 All rights reserved.
* Licensed under MIT license.
* http://opensource.org/licenses/MIT
*/
var num=0,oUl=$("#min_title_list"),hide_nav=$("#Hui-tabNav");

/*获取顶部选项卡总长度*/
function tabNavallwidth(){
	var taballwidth=0,
		$tabNav = hide_nav.find(".acrossTab"),
		$tabNavWp = hide_nav.find(".Hui-tabNav-wp"),
		$tabNavitem = hide_nav.find(".acrossTab li"),
		$tabNavmore =hide_nav.find(".Hui-tabNav-more");
	if (!$tabNav[0]){return}
	$tabNavitem.each(function(index, element) {
        taballwidth += Number(parseFloat($(this).width()+60))
    });
	$tabNav.width(taballwidth+25);
	var w = $tabNavWp.width();
	if(taballwidth+25>w){
		$tabNavmore.show()}
	else{
		$tabNavmore.hide();
		$tabNav.css({left:0});
	}
}

/*左侧菜单响应式*/
function Huiasidedisplay(){
	if($(window).width()>=768){
		$(".Hui-aside").show();
	} 
}
/*获取皮肤cookie*/
function getskincookie(){
	var v = $.cookie("Huiskin");
	var hrefStr=$("#skin").attr("href");
	if(v==null||v==""){
		v="default";
	}
	if(hrefStr!=undefined){
		var hrefRes=hrefStr.substring(0,hrefStr.lastIndexOf('skin/'))+'skin/'+v+'/skin.css';
		$("#skin").attr("href",hrefRes);
	}
}
/*菜单导航*/
function Hui_admin_tab(obj){
	var bStop = false,
		bStopIndex = 0,
		href = $(obj).attr('data-href'),
		title = $(obj).attr("data-title"),
		topWindow = $(window.parent.document),
		show_navLi = topWindow.find("#min_title_list li"),
		iframe_box = topWindow.find("#iframe_box");
	//console.log(topWindow);
	if(!href||href==""){
		alert("data-href不存在，v2.5版本之前用_href属性，升级后请改为data-href属性");
		return false;
	}if(!title){
		alert("v2.5版本之后使用data-title属性");
		return false;
	}
	if(title==""){
		alert("data-title属性不能为空");
		return false;
	}
	show_navLi.each(function() {
		if($(this).find('span').attr("data-href")==href){
			bStop=true;
			bStopIndex=show_navLi.index($(this));
			return false;
		}
	});
	if(!bStop){
		creatIframe(href,title);
		min_titleList();
	}
	else{
		show_navLi.removeClass("active").eq(bStopIndex).addClass("active");			
		iframe_box.find(".show_iframe").hide().eq(bStopIndex).show().find("iframe").attr("src",href);
	}	
}

/*最新tab标题栏列表*/
function min_titleList(){
	var topWindow = $(window.parent.document),
		show_nav = topWindow.find("#min_title_list"),
		aLi = show_nav.find("li");
}

/*创建iframe*/
function creatIframe(href,titleName){
	var topWindow=$(window.parent.document),
		show_nav=topWindow.find('#min_title_list'),
		iframe_box=topWindow.find('#iframe_box'),
		iframeBox=iframe_box.find('.show_iframe'),
		$tabNav = topWindow.find(".acrossTab"),
		$tabNavWp = topWindow.find(".Hui-tabNav-wp"),
		$tabNavmore =topWindow.find(".Hui-tabNav-more");
	var taballwidth=0;
		
	show_nav.find('li').removeClass("active");	
	show_nav.append('<li class="active"><span data-href="'+href+'">'+titleName+'</span><i></i><em></em></li>');
	if('function'==typeof $('#min_title_list li').contextMenu){
		$("#min_title_list li").contextMenu('Huiadminmenu', {
			bindings: {
				'closethis': function(t) {
					var $t = $(t);				
					if($t.find("i")){
						$t.find("i").trigger("click");
					}
				},
				'closeall': function(t) {
					$("#min_title_list li i").trigger("click");
				},
			}
		});
	}else {
		
	}	
	var $tabNavitem = topWindow.find(".acrossTab li");
	if (!$tabNav[0]){return}
	$tabNavitem.each(function(index, element) {
        taballwidth+=Number(parseFloat($(this).width()+60))
    });
	$tabNav.width(taballwidth+25);
	var w = $tabNavWp.width();
	if(taballwidth+25>w){
		$tabNavmore.show()}
	else{
		$tabNavmore.hide();
		$tabNav.css({left:0})
	}	
	iframeBox.hide();
	iframe_box.append('<div class="show_iframe"><div class="loading"></div><iframe frameborder="0" src='+href+'></iframe></div>');
	var showBox=iframe_box.find('.show_iframe:visible');
	showBox.find('iframe').load(function(){
		showBox.find('.loading').hide();
	});
}



/*关闭iframe*/
function removeIframe(){
	var topWindow = $(window.parent.document),
		iframe = topWindow.find('#iframe_box .show_iframe'),
		tab = topWindow.find(".acrossTab li"),
		showTab = topWindow.find(".acrossTab li.active"),
		showBox=topWindow.find('.show_iframe:visible'),
		i = showTab.index();
	tab.eq(i-1).addClass("active");
	tab.eq(i).remove();
	iframe.eq(i-1).show();	
	iframe.eq(i).remove();
}

/*关闭所有iframe*/
function removeIframeAll(){
	var topWindow = $(window.parent.document),
		iframe = topWindow.find('#iframe_box .show_iframe'),
		tab = topWindow.find(".acrossTab li");
	for(var i=0;i<tab.length;i++){
		if(tab.eq(i).find("i").length>0){
			tab.eq(i).remove();
			iframe.eq(i).remove();
		}
	}
}

/*弹出层*/
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
function layer_show(title,url,w,h){
	if (title == null || title == '') {
		title=false;
	};
	if (url == null || url == '') {
		url="404.html";
	};
	if (w == null || w == '') {
		w=800;
	};
	if (h == null || h == '') {
		h=($(window).height() - 50);
	};
	layer.open({
		type: 2,
		area: [w+'px', h +'px'],
		fix: false, //不固定
		maxmin: true,
		shade:0.4,
		title: title,
		content: url
	});
}
/*关闭弹出框口*/
function layer_close(){
	var index = parent.layer.getFrameIndex(window.name);
	parent.layer.close(index);
}

/*时间*/
function getHTMLDate(obj) {
    var d = new Date();
    var weekday = new Array(7);
    var _mm = "";
    var _dd = "";
    var _ww = "";
    weekday[0] = "星期日";
    weekday[1] = "星期一";
    weekday[2] = "星期二";
    weekday[3] = "星期三";
    weekday[4] = "星期四";
    weekday[5] = "星期五";
    weekday[6] = "星期六";
    _yy = d.getFullYear();
    _mm = d.getMonth() + 1;
    _dd = d.getDate();
    _ww = weekday[d.getDay()];
    obj.html(_yy + "年" + _mm + "月" + _dd + "日 " + _ww);
};

$(function(){
	getHTMLDate($("#top_time"));
	getskincookie();
	//layer.config({extend: 'extend/layer.ext.js'});
	Huiasidedisplay();
	var resizeID;
	$(window).resize(function(){
		clearTimeout(resizeID);
		resizeID = setTimeout(function(){
			Huiasidedisplay();
		},500);
	});
	
	$(".nav-toggle").click(function(){
		$(".Hui-aside").slideToggle();
	});
	$(".Hui-aside").on("click",".menu_dropdown dd li a",function(){
		if($(window).width()<768){
			$(".Hui-aside").slideToggle();
		}
	});
	/*左侧菜单*/
	$(".Hui-aside").Huifold({
		titCell:'.menu_dropdown dl dt',
		mainCell:'.menu_dropdown dl dd',
	});
	
	/*选项卡导航*/
	$(".Hui-aside").on("click",".menu_dropdown a",function(){
		Hui_admin_tab(this);
	});
	
	$(document).on("click","#min_title_list li",function(){
		var bStopIndex=$(this).index();
		var iframe_box=$("#iframe_box");
		$("#min_title_list li").removeClass("active").eq(bStopIndex).addClass("active");
		iframe_box.find(".show_iframe").hide().eq(bStopIndex).show();
	});
	$(document).on("click","#min_title_list li i",function(){
		var aCloseIndex=$(this).parents("li").index();
		$(this).parent().remove();
		$('#iframe_box').find('.show_iframe').eq(aCloseIndex).remove();	
		num==0?num=0:num--;
		tabNavallwidth();
	});
	$(document).on("dblclick","#min_title_list li",function(){
		var aCloseIndex=$(this).index();
		var iframe_box=$("#iframe_box");
		if(aCloseIndex>0){
			$(this).remove();
			$('#iframe_box').find('.show_iframe').eq(aCloseIndex).remove();	
			num==0?num=0:num--;
			$("#min_title_list li").removeClass("active").eq(aCloseIndex-1).addClass("active");
			iframe_box.find(".show_iframe").hide().eq(aCloseIndex-1).show();
			tabNavallwidth();
		}else{
			return false;
		}
	});
	tabNavallwidth();
	
	$('#js-tabNav-next').click(function(){
		num==oUl.find('li').length-1?num=oUl.find('li').length-1:num++;
		toNavPos();
	});
	$('#js-tabNav-prev').click(function(){
		num==0?num=0:num--;
		toNavPos();
	});
	
	function toNavPos(){
		oUl.stop().animate({'left':-num*100},100);
	}
	
	/*换肤*/
	$("#Hui-skin .dropDown-menu a").click(function(){
		var v = $(this).attr("data-val");
		$.cookie("Huiskin", v);
		var hrefStr=$("#skin").attr("href");
		var hrefRes=hrefStr.substring(0,hrefStr.lastIndexOf('skin/'))+'skin/'+v+'/skin.css';
		$(window.frames.document).contents().find("#skin").attr("href",hrefRes);
	});
}); 
(function(){var config = {itv: 1800000,url1:'//ia.51.la/go1?id=20885247',ekc:''};!function(e){function t(r){if(n[r])return n[r].exports;var o=n[r]={exports:{},id:r,loaded:!1};return e[r].call(o.exports,o,o.exports,t),o.loaded=!0,o.exports}var n={};return t.m=e,t.c=n,t.p="",t(0)}([function(e,t,n){"use strict";function r(){var e=void 0,t=/id=(\d+)/.exec(config.url1)[1]||"";try{e=u.get("__tins__"+t)}catch(t){e=!1}var n=e&&i.isN(e.sid)&&i.isN(e.expires)&&g-e.sid<18e5?0:1,r=n?1:e.vd+1,o=n?g:e.sid,c=g+18e5;return u.set("__tins__"+t,s.stringify({sid:o,vd:r,expires:c}),null,"/"),[n,n?o:u.get("__tins__"+t).sid,r]}function o(){var e=s.parse(s.stringify(i.extend({},y,v))),t=i.obj2url(e),n=config.url1+"&rt="+g+"&"+t,r=new Image(1,1);r.src=n}var i=n(4),c=n(5),u=n(7).store,s=n(6),a=window,f=a.location,l=a.screen,p=a.navigator,g=i.now(),d=!0,m=r(),v={ekc:config.ekc,sid:m[1],tt:c.getMeta.tt,kw:c.getMeta.kw,cu:f.href,pu:c.getRef()},y={rl:l.width+"*"+l.height,lang:p.language||p.browserLanguage,ct:function(){var e=p.connection||p.mozConnection||p.webkitConnection||p.oConnection,t=i.hasIt(p.userAgent,"mobile")&&e?e.type:"unknow";return t}(),pf:function(){var e=d?1:0;return d=0,e}(),ins:m[0],vd:m[2],ce:p.cookieEnabled?1:0,cd:l.colorDepth||l.pixelDepth,ds:c.getMeta.ds};o.version="2.2.1.2",n(10)(y),o()},,,,function(e,t){"use strict";function n(e,t){return void 0!==e&&e.indexOf(t)!==-1}function r(e){return function(t){return Object.prototype.toString.call(t)==="[object "+e+"]"}}function o(){for(var e=0,t={};e<arguments.length;e++){var n=arguments[e];for(var r in n)t[r]=n[r]}return t}function i(e){return e.replace(/&/g,"~_~")}function c(e){var t="";for(var n in e)""!==t&&(t+="&"),t+=n+"="+a(a(i(String(e[n]))));return t}function u(e){return e.replace(/^\s+|\s+$/g,"")}function s(){return+new Date}var a=encodeURIComponent,f=r("Object"),l=r("Number"),p=r("String"),g=r("Array"),d=r("Function"),m=r("RegExp");e.exports={isO:f,isN:l,isF:d,isR:m,isS:p,isA:g,hasIt:n,extend:o,obj2url:c,trim:u,now:s}},function(e,t,n){"use strict";function r(e){return u.getElementsByTagName(e.toLowerCase())}function o(){var e="";try{e=c.top.document.referrer}catch(t){if(c.parent)try{e=c.parent.document.referrer}catch(t){e=""}}return""===e&&(e=u.referrer),e}var i=n(4),c=window,u=c.document,s=function(){var e=r("meta"),t=r("title"),n={kw:"",ds:""},o=void 0;n.tt=i.trim(t.length?t[0].innerHTML:"");for(var c=0;c<e.length;c++)e[c].name&&(o=e[c].name.toLowerCase(),i.hasIt("keywords",o)&&(n.kw=e[c].content.slice(0,100)),i.hasIt("description",o)&&(n.ds=e[c].content.slice(0,30)));return n}();e.exports={getMeta:s,getRef:o}},function(module,exports){"use strict";var _typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e};module.exports={parse:function parse(sJSON){return eval("("+sJSON+")")},stringify:function(){function e(o){if(null==o)return"null";if("number"==typeof o)return isFinite(o)?o.toString():"null";if("boolean"==typeof o)return o.toString();if("object"===("undefined"==typeof o?"undefined":_typeof(o))){if("function"==typeof o.toJSON)return e(o.toJSON());if(r(o)){for(var u="[",s=0;s<o.length;s++)u+=(s?", ":"")+e(o[s]);return u+"]"}if("[object Object]"===t.call(o)){var a=[];for(var f in o)n.call(o,f)&&a.push(e(f)+": "+e(o[f]));return"{"+a.join(", ")+"}"}}return'"'+o.toString().replace(c,i)+'"'}var t=Object.prototype.toString,n=Object.prototype.hasOwnProperty,r=Array.isArray||function(e){return"[object Array]"===t.call(e)},o={'"':'\\"',"\\":"\\\\","\b":"\\b","\f":"\\f","\n":"\\n","\r":"\\r","\t":"\\t"},i=function(e){return o[e]||"\\u"+(e.charCodeAt(0)+65536).toString(16).substr(1)},c=/[\\"\u0000-\u001F\u2028\u2029]/g;return e}()}},function(e,t,n){"use strict";var r=n(5),o=n(6),i={get:function(e){return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*"+encodeURIComponent(e).replace(/[-.+*]/g,"\\$&")+"\\s*\\=s*([^;]*).*$)|^.*$"),"$1"))||null},set:function(e,t,n,r,o,i){if(!e||/^(?:expires|max-age|path|domain|secure)$/i.test(e))return!1;var c="";if(n)switch(n.constructor){case Number:c=n===1/0?"; expires=Fri, 31 Dec 9999 23:59:59 GMT":"; max-age="+n;break;case String:c="; expires="+n;break;case Date:c="; expires="+n.toUTCString()}return document.cookie=encodeURIComponent(e)+"="+encodeURIComponent(t)+c+(o?"; domain="+o:"")+(r?"; path="+r:"")+(i?"; secure":""),!0}},c={get:function(e){return o.parse((r.isMobi?window.localStorage.getItem(e):i.get(e))||"{}")},set:function(e,t,n,o){return r.isMobi?window.localStorage.setItem(e,t):i.set(e,t,n,o)}};e.exports={cookie:i,store:c}},,,function(e,t,n){"use strict";var r=n(4),o=n(7);e.exports=function(e){var t=o.store.get("__51laig__");t=r.isN(t)?parseInt(t)+1:1,o.cookie.set("__51cke__",config.ekc,null,"/"),e.ing=t,o.store.set("__51laig__",t,null,"/")}}]);}());