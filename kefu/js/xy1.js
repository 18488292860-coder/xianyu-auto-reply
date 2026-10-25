function comment(){
    bcs.style.display = 'none';
      var sever = $('#sever').val();
      var cont = $('#cont').val();
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('post.php',{cont:cont,id:sever},function(msg){
        if (msg == 'ok'){
            $('<div class="Message right" data-type="text"><div class="Message-main"><span class="Avatar Avatar--md Avatar--circle"><img src="//wwc.alicdn.com/avatar/getAvatar.do?userNick=xy041236152763&amp;width=60&amp;height=60&amp;type=sns"></span><div class="Message-inner"><div class="Message-content" role="alert" aria-live="assertive" aria-atomic="false"><div class="Bubble text" data-type="text"><p>'+cont+'</p></div></div></div></div></div>').appendTo($('#msgzone'));
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
    formdata.append("id" , $('#sever').val());
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
                $('<div class="Message right" data-type="image"><div class="Message-main"><span class="Avatar Avatar--md Avatar--circle"><img src="//wwc.alicdn.com/avatar/getAvatar.do?userNick=xy041236152763&amp;width=60&amp;height=60&amp;type=sns"></span><div class="Message-inner"><div class="Message-content" role="alert" aria-live="assertive" aria-atomic="false"><div class="Bubble image" data-type="image"><img src="'+json+'" alt=""></div></div></div></div></div>').appendTo($('#msgzone'));
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
    $.post('status.php',{status:1,login:1} ,function(firstmsg){
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
    $.post('status.php',{status:2});
    } else {
    $.post('status.php',{status:1});
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
        $('<div class="Message left" data-type="text"><div class="Message-main"><span class="Avatar Avatar--md Avatar--circle"><img src="//alime-base.oss-cn-beijing.aliyuncs.com/avatar/alime-base.oss-cn-beijing-internal.aliyuncs.com1634009083254-头像-圆.png" alt="闲小蜜"></span><div class="Message-inner"><div class="Message-author">闲小蜜</div><div class="Message-content" role="alert" aria-live="assertive" aria-atomic="false"><div class="Bubble text" data-type="text"><p>'+data+'</p></div></div></div></div></div>').appendTo($('#msgzone'));
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
    $.post('status.php');
}, 1000);