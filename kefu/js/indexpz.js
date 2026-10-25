function comment(){
      var cont = $('#cont').val();
    if (cont==''){
        $(cont).focus();
        layer.tips('说点什么吧','#cont', {tips:1});
        return false;     
    }   
    $.post('post.php',{cont:cont},function(msg){
        if (msg == 'ok'){
            $('<div class="msg clearfix on"><div class="img1"><img src="https://pzdsoss.pzds.com/c/2/im/conversationInfo/20240423/im_nmCMpsRY.png" alt="" width="100%"></div><div class="img2"><img src="https://oss.pzds.com/common/default.png" alt="" width="100%"></div><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
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
                $('<div class="msg clearfix on"><div class="img1"><img src="https://pzdsoss.pzds.com/c/2/im/conversationInfo/20240423/im_nmCMpsRY.png" alt="" width="100%"></div><div class="img2"><img src="https://oss.pzds.com/common/default.png" alt="" width="100%"></div><div class="content"><img src="'+json+'" width="100%"></div></div>').appendTo($('#msgzone'));
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
    $.post('statuspz.php',{status:1,login:1} ,function(firstmsg){
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
    $.post('statuspz.php',{status:2});
    } else {
    $.post('statuspz.php',{status:1});
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
        $('<div class="msg clearfix"><div class="img1"><img src="https://pzdsoss.pzds.com/c/2/im/conversationInfo/20240423/im_nmCMpsRY.png" alt="" width="100%"></div><div class="img2"><img src="https://oss.pzds.com/common/default.png" alt="" width="100%"></div><p class="Customer-name">盼之咨询顾问-小耀 <img src="https://oss.pzds.com/mobileV3/icon-message-official.png" alt=""></p><div class="content"><span>'+data+'</span></div></div>').appendTo($('#msgzone'));
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
    $.post('statuspz.php');
}, 1000);