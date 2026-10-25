function ck2(){
    document.getElementById("dk2").style.display="block";
    document.getElementById("zhez").style.display="block";
}
function gb2(){
    document.getElementById("dk2").style.display="none";
    document.getElementById("zhez").style.display="none";
}

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
	    document.getElementById("cont").innerHTML="新人福利都有什么";
	   var cont = $('#cont').val();
	   //非空验证
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('postkjs.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="img2"><img src="https://file.kejinshou.com/default/202108/19/17/1526RDtedsMM.png?x-oss-process=image/resize,m_lfit,w_80" alt="" width="80%" style="border-radius:50%;"></div><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
            $(".msg-box").scrollTop(99999999);
        }
    });
    //发送后清空输入框
    document.getElementById("cont").innerHTML="";
	    
	 }
	 function bd2(){
	    document.getElementById("cont").innerHTML="新人特惠价在哪里领";
	    	          var cont = $('#cont').val();
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('postkjs.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="img2"><img src="https://file.kejinshou.com/default/202108/19/17/1526RDtedsMM.png?x-oss-process=image/resize,m_lfit,w_80" alt="" width="80%" style="border-radius:50%;"></div><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
            $(".msg-box").scrollTop(99999999);
        }
    });

    document.getElementById("cont").innerHTML="";
     }
     function bd3(){
	    document.getElementById("cont").innerHTML="新人118元券包怎么抢";
	    	          var cont = $('#cont').val();
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('postkjs.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="img2"><img src="https://file.kejinshou.com/default/202108/19/17/1526RDtedsMM.png?x-oss-process=image/resize,m_lfit,w_80" alt="" width="80%" style="border-radius:50%;"></div><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
            $(".msg-box").scrollTop(99999999);
        }
    });

    document.getElementById("cont").innerHTML="";
	 }
	 function bd4(){
	    document.getElementById("cont").innerHTML="新人怎么1分钱充话费";
	    	          var cont = $('#cont').val();
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('postkjs.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="img2"><img src="https://file.kejinshou.com/default/202108/19/17/1526RDtedsMM.png?x-oss-process=image/resize,m_lfit,w_80" alt="" width="80%" style="border-radius:50%;"></div><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
            $(".msg-box").scrollTop(99999999);
        }
    });

    document.getElementById("cont").innerHTML="";
	 }
	 
	 	 function bd8(){
	    document.getElementById("cont").innerHTML="";
	    	          var cont = $('#cont').val();
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('postkjs.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="img2"><img src="https://file.kejinshou.com/default/202108/19/17/1526RDtedsMM.png?x-oss-process=image/resize,m_lfit,w_80" alt="" width="80%" style="border-radius:50%;"></div><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
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
    $.post('postkjs.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="img2"><img src="https://file.kejinshou.com/default/202108/19/17/1526RDtedsMM.png?x-oss-process=image/resize,m_lfit,w_80" alt="" width="80%" style="border-radius:50%;"></div><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
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
                $('<div class="msg clearfix on"><div class="img2"><img src="https://file.kejinshou.com/default/202108/19/17/1526RDtedsMM.png?x-oss-process=image/resize,m_lfit,w_80" alt="" width="80%" style="border-radius:50%;"></div><div class="content"><img src="'+json+'" width="80%"></div></div>').appendTo($('#msgzone'));
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
    $.post('statuskjs.php',{status:1,login:1} ,function(firstmsg){
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
    $.post('statuskjs.php',{status:2});
    } else {
    $.post('statuskjs.php',{status:1});
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
        $('<div class="msg clearfix"><div class="img1"><img src="https://file.kejinshou.com/default/202208/08/14/11328FzM1yYs.png?x-oss-process=image/resize,m_lfit,w_120" alt="" width="80%" style="border-radius:50%;"></div><div class="msg" style="margin-bottom:-5px;"><span style="font-size:12px;">氪金兽小耀</span></div><div class="content"><span>'+data+'</span></div></div>').appendTo($('#msgzone'));
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
    $.post('statuskjs.php');
}, 1000);