function ck1(){
    document.getElementById("dk1").style.display="block";
    document.getElementById("zhez").style.display="block";
}
function gb1(){
    document.getElementById("dk1").style.display="none";
    document.getElementById("zhez").style.display="none";
}
function lxkf(){
    setTimeout(function() {
         document.getElementById("ddkf").style.display='block';
              setTimeout(function() {
                   document.getElementById("ddkf1").style.display='block';
                        setTimeout(function() {
                             document.getElementById("ddkf21").style.display='block';
                        }, 500);
              }, 500);
    }, 500);
}
		 function bd5(){
	     document.getElementById("bd").style.display='none';
	     document.getElementById("bd777").style.display='block';
	     document.getElementById("bd999").style.display='block';
	     function to_footer() {
    var div = document.getElementById('bd777');
    div.scrollTop = div.scrollHeight;
}
	 }
	 function bd6(){
	     document.getElementById("bd").style.display='block';
	     document.getElementById("bd777").style.display='none';
	     document.getElementById("bd999").style.display='none';
	 }
	    
function bd1(){
        //给输入框填写信息
	    document.getElementById("cont").innerHTML="游戏商品如何发布";
	   var cont = $('#cont').val();
	   //非空验证
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('postzz.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix"><div class="content"><div data-v-62298420="" data-v-444981c8="" class="z-tip-trigger" data-msgid="sepMsgItem??1676976882008067953" data-v-6dd26d3a="" style="width: 100%;"><div data-v-62298420="" class="msg-container canLikeMsg"><!----><div data-v-62298420=""><div data-v-62298420="" class="msg-container-wrap" style="height: 154.56px;"><div data-v-62298420="" class="box-content"><div class="athena-rich-text-content"><div class="athena-rich-text-desc"><span class=""><p>'+cont+'</p><p><img src="https://pic1.zhuanstatic.com/zhuanzh/236944c3-9865-44d1-b076-db299cc0eb35.png?t=5&amp;qa=90" style="max-width:100%;" contenteditable="false"></p></span></div></div></div></div><div data-v-62298420="" class="msg-more"><div data-v-62298420="" class="msg-more-mask"></div><span data-v-62298420="" class="msg-more-text">查看全部</span></div><!----><!----><!----><div data-v-62298420="" class="extra-btn-area"><!----></div><div data-v-62298420="" class="extra-btn-area"><!----><!----></div><div data-v-62298420="" class="commit-like"><div data-v-62298420="" class="commit-like-wrap"><div data-v-62298420="" class="yes"><div data-v-62298420="" class="icon"></div><span data-v-62298420="">已解决</span></div><div data-v-62298420="" class="no"><div data-v-62298420="" class="icon"></div><span data-v-62298420="">未解决</span></div><div data-v-62298420="" class="clear"></div></div></div><!----></div></div><div class="z-tip" style="visibility: hidden; display: none;"><i class="top z-tip-angle" style="left: 33px;"></i><i class="z-icon zziconfont-6 zziconfont-6-close z-tip-close"><!----></i><div class="z-tip-content"><div data-v-62298420=""><p data-v-62298420="" data-clipboard-action="copy" data-clipboard-text=""> 复制 </p></div></div></div></div></div></div>').appendTo($('#msgzone'));
            $(".msg-box").scrollTop(99999999);
        }
    });
    //发送后清空输入框
    document.getElementById("cont").innerHTML="";
	    
	 }
	 function bd2(){
	    document.getElementById("cont").innerHTML="测试";
	    	          var cont = $('#cont').val();
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('postzz.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
            $(".msg-box").scrollTop(99999999);
        }
    });

    document.getElementById("cont").innerHTML="";
     }
     function bd3(){
	    document.getElementById("cont").innerHTML="测试";
	    	          var cont = $('#cont').val();
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('postzz.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
            $(".msg-box").scrollTop(99999999);
        }
    });

    document.getElementById("cont").innerHTML="";
	 }
	 function bd4(){
	    document.getElementById("cont").innerHTML="测试";
	    	          var cont = $('#cont').val();
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('postzz.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
            $(".msg-box").scrollTop(99999999);
        }
    });

    document.getElementById("cont").innerHTML="";
	 }
	 
	 	 function bd8(){
	    document.getElementById("cont").innerHTML="测试";
	    	          var cont = $('#cont').val();
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('postzz.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
            $(".msg-box").scrollTop(99999999);
        }
    });

    document.getElementById("cont").innerHTML="";
	 }
function comment(){
      var cont = $('#cont').val();
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('postzz.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
            $(".msg-box").scrollTop(99999999);
        }
    });

    document.querySelector("textarea").value = "";
}

$(document).keydown(function(event){
    if (event.keyCode == 13) {
        comment();
        event.returnValue = false;
        return false;
    }
});
function upload(){
    var formdata=new FormData(); 
    formdata.append("file" , $("#file")[0].files[0]);
    $.ajax({
        type : 'post',
        url : 'img.php',
        data : formdata,
        cache : false,
        processData : false,
        contentType : false, 
        success : function(json){
            var reg = RegExp(/upload/);
            if(json.match(reg)){
                $('<div class="msg clearfix on"><div class="content"><img src="'+json+'" width="80%"></div></div>').appendTo($('#msgzone'));
                var top=999999999;
                var startTime = new Date().getTime();
                var interval = setInterval(function(){
                    if(new Date().getTime() - startTime > 2000){
                    clearInterval(interval);
                    return;
                    }
                $(".msg-box").scrollTop(top++);
                }, 1);
            }else{
                layer.msg(json);
            }	
        }  
    })
}
window.onload = function(){
    $.post('statuszz.php',{status:1,login:1} ,function(firstmsg){
        if(firstmsg[0] < 1){
            var audio = new Audio();
            audio.autoplay = true ;
            audio.src = 'msg.mp3' ;
            document.body.appendChild(audio);
        }else{
            $(".msg-box").scrollTop(99999999);
        }
        document.querySelector("#first-msg").innerHTML = firstmsg[1];
    }, "json");
}
document.addEventListener('visibilitychange',function(){
    var isHidden = document.hidden;
    if(isHidden){	
    $.post('statuszz.php',{status:2});
    } else {
    $.post('statuszz.php',{status:1});
    $(".msg-box").scrollTop(99999999);
    }
});

$.ajaxSetup ({ cache: false });
setInterval(function(){
    $.getJSON("user_data.php", function(data){
        var audio = new Audio();
        audio.autoplay = true ;
        audio.src = 'msg.mp3' ;
        document.body.appendChild(audio);		
        $('<div class="msg clearfix"><div class="content"><span>'+data+'</span></div></div>').appendTo($('#msgzone'));
        var top=999999999;
        var startTime = new Date().getTime();
        var interval = setInterval(function(){
            if(new Date().getTime() - startTime > 2000){
            clearInterval(interval);
            return;
            }
        $(".msg-box").scrollTop(top++);
        }, 1);
    });	
    $.post('statuszz.php');
}, 1000);