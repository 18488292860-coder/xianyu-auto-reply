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
function comment(){
    var assignee = $('#assignee').val();
    var cont = $('#cont').val();
  if (cont==''){
      $(cont).focus();
      layer.tips('说点什么吧','#cont', {tips:1});
      return false;     
  }   
  $.post('/kefu/post.php',{cont:cont,assignee:assignee},function(msg){
      if (msg == 'ok'){
          $('<div class="msg clearfix on"><div class="img1"><img src="//alime-base.oss-cn-beijing.aliyuncs.com/avatar/alime-base.oss-cn-beijing-internal.aliyuncs.com1634009083254-头像-圆.png" alt="" width="80%"></div><div class="content"><span>'+cont+'</span></div></div>').appendTo($('#msgzone'));
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
  var assignee = $('#assignee').val();
  var formdata=new FormData(); 
  formdata.append('assignee', assignee);
  formdata.append("file" , $("#file")[0].files[0]);
  $.ajax({
      type : 'post',
      url : '/img.php',
      data : formdata,
      cache : false,
      processData : false,
      contentType : false, 
      success : function(json){
          var reg = RegExp(/upload/);
          if(json.match(reg)){
              $('<div class="msg clearfix on"><div class="img1"><img src="//alime-base.oss-cn-beijing.aliyuncs.com/avatar/alime-base.oss-cn-beijing-internal.aliyuncs.com1634009083254-头像-圆.png" alt="" width="80%"></div><div class="content"><img src="'+json+'" width="100%"></div></div>').appendTo($('#msgzone'));
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
  $.post('/kefu/status.php',{status:1,login:1} ,function(firstmsg){
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
  $.post('/kefu/status.php',{status:2});
  } else {
  $.post('/kefu/status.php',{status:1});
  $(".msg-box").scrollTop(99999999);
  }
});

$.ajaxSetup ({ cache: false });
setInterval(function(){
  $.getJSON("/kefu/user_data.php", function(data){
      var audio = new Audio();
      audio.autoplay = true ;
      audio.src = 'msg.mp3' ;
      document.body.appendChild(audio);		
      $('<div class="msg clearfix"><div class="img1"><img src="//alime-base.oss-cn-beijing.aliyuncs.com/avatar/alime-base.oss-cn-beijing-internal.aliyuncs.com1634009083254-头像-圆.png" alt="" width="80%"></div><div class="content"><span>'+data+'</span></div></div>').appendTo($('#msgzone'));
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
  $.post('/kefu/status.php');
}, 1000);