<?php
require_once './include/conn.php';
?>
<!DOCTYPE html>
<html lang="en"style="font-size:41.4px;"class="user-select-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>转转</title>
	<link rel="stylesheet" href="/css/stylezz1.css">
	<link rel="stylesheet" href="/iconfont/iconfont.css">
	<link rel="shortcut icon" href="https://m.zhuanzhuan.com/favicon.ico">
	<link rel="icon" href="https://m.zhuanzhuan.com/favicon.ico">
	<link rel="apple-touch-icon" href="https://m.zhuanzhuan.com/favicon.ico">
	<link rel="stylesheet" type="text/css" href="https://s1.zhuanstatic.com/system/zzappimservice/static/css/503.415697be.css">
	<link rel="stylesheet" type="text/css" href="/css/zz460.css">
	<script src="/js/jquery.min.js"></script>
	<script src="/js/layer.js"></script>
	<script src="/js/indexzzz.js"></script>


</head>
<body style="font-size:16px;">
	<div class="service" style="background-color:#f8f8f8;">

	    <div class="msg-head text-center" style="background-color:#fff; height:48px;">
			<a href="javascript:;" onclick="history.go(-1);"><i class="icon-back z-icon zziconfont-5 zziconfont-5-back"></i></a>
				<span style="title-text">在线客服</span>
	    </div>
		<div class="msg-box"style="background-color:#f8f8f8;">
		    <div class="msg clearfix">

		        <div class="msg-item-base common-msg-item">
				    <div data-v-6dd26d3a="" data-v-4495328c="" class="msg-item-base common-msg-item" data-v-d3a9bbd2=""><!----><!----><div data-v-6dd26d3a="" class="base-container ease-in-show float-left athena-width"><div data-v-6dd26d3a="" class="base-content float-left athena-width"><div data-v-62298420="" data-v-4495328c="" class="z-tip-trigger" data-msgid="sepMsgOption??1676463890295674344" data-v-6dd26d3a="" style="width: 100%;"><div data-v-62298420="" class="msg-container"><!----><div data-v-62298420=""><div data-v-62298420="" class="msg-container-wrap" style="height: auto;"><div data-v-62298420="" class="box-content"><div class="athena-rich-text-content"><div class="athena-rich-text-options"><div class="athena-rich-text-options-title"><p>大家还问了这些</p></div><div class="athena-rich-text-options-wrap" onclick="bd1();"><p class="athena-rich-text-options-card">游戏商品如何发布</p><p class="athena-rich-text-options-right"></p></div><div class="athena-rich-text-options-wrap" onclick="bd2()"><p class="athena-rich-text-options-card" >游戏服务费收费标准</p><p class="athena-rich-text-options-right"></p></div><div class="athena-rich-text-options-wrap"><p class="athena-rich-text-options-card" onclick="bd3()">如何转接人工客服</p><p class="athena-rich-text-options-right"></p></div><div class="athena-rich-text-options-wrap" onclick="bd4()"><p class="athena-rich-text-options-card" >购买的账号被找回怎么办</p><p class="athena-rich-text-options-right"></p></div><div class="athena-rich-text-options-wrap" onclick="bd8()"><p class="athena-rich-text-options-card" >如何取消订单</p><p class="athena-rich-text-options-right"></p></div></div></div></div></div><!----><!----><!----><!----><div data-v-62298420="" class="extra-btn-area"><!----></div><div data-v-62298420="" class="extra-btn-area"><!----><!----></div><!----><!----></div></div><div class="z-tip" style="visibility: hidden; display: none;"><i class="top z-tip-angle" style="left: 33px;"></i><i class="z-icon zziconfont-6 zziconfont-6-close z-tip-close"><!----></i><div class="z-tip-content"><div data-v-62298420=""><p data-v-62298420="" data-clipboard-action="copy" data-clipboard-text=""> 复制 </p></div></div></div></div><img data-v-6dd26d3a="" src="data:image/gif;base64,R0lGODlhIAAgAPekAPz8/Onp6ejo6Ovr6+zs7HKu/vDw8PHx8fr6+v39/fLy8vT09Pf39+3t7fn5+fv7++7u7urq6v///3yz/Pr8/nSv/new/enx/Pv9/pXA+aTI+XOv/sre+bjU+fb5/vf6/o27+t3q+6LH+fj7/oW4+3Ww/efw/KbK+H20/HWv/ejx/Ii5+nix/eLt+6XJ+fD2/ery/Ia4+67O+ejw/KXJ+I27+a3O+fn7/uzz/PD1/XOu/uvy/JfB+oe4+4W4+qHH+Y+9+dff6nuz/Iy7+u/1/Xiw/Yi6+o+9+o67+fX5/rfT+dfm+tjn+sbX7eHs+8fX7Y69+tnn+oW3+9ro+pC++ZbA+djh7aTG9KnL+MbX7rPR+Xaw/c7f9vv8/s/h+Z3E+MTW7uXn6vv8/eDr+v39/svb8I28+svf+fz9/t7q+6bJ+Pb6/szd9K3N+ZC9+cvf+vz9/7rU+fX4/Yu7+q7N+Ya4+nmy/Xmx/aLF9djh7nuy/Mrc9JK++dzq+5K/+ebn6vv8/8zb8K/P+aXH9PX5/d/r+8zf+d/q+uDs+9fg7Z7E+KHG+d/r+tno+svc8J7F+Obv/JXA+srf+aDG+eTn6tbf6tjn+8/f9Y68+cvc9JbB+YG1+93p+/39/5G++enx/bjT+c/g9v7+/ufn5////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh/wtYTVAgRGF0YVhNUDw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTM4IDc5LjE1OTgyNCwgMjAxNi8wOS8xNC0wMTowOTowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDozY2U5NWIwNy01NmQ1LTQzZjQtYThjNy1lM2Y3YzM1N2FhNmQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6Q0M1ODhEMDg0MjEyMTFFODk1OUVFQTdGNEZCMENCNjYiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6Q0M1ODhEMDc0MjEyMTFFODk1OUVFQTdGNEZCMENCNjYiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDozY2U5NWIwNy01NmQ1LTQzZjQtYThjNy1lM2Y3YzM1N2FhNmQiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6M2NlOTViMDctNTZkNS00M2Y0LWE4YzctZTNmN2MzNTdhYTZkIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+Af/+/fz7+vn49/b19PPy8fDv7u3s6+rp6Ofm5eTj4uHg397d3Nva2djX1tXU09LR0M/OzczLysnIx8bFxMPCwcC/vr28u7q5uLe2tbSzsrGwr66trKuqqainpqWko6KhoJ+enZybmpmYl5aVlJOSkZCPjo2Mi4qJ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" class="state" style="display: none;"><img data-v-6dd26d3a="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAAERlWElmTU0AKgAAAAgAAYdpAAQAAAABAAAAGgAAAAAAA6ABAAMAAAABAAEAAKACAAQAAAABAAAAJKADAAQAAAABAAAAJAAAAAAqDuP8AAADEklEQVRYCc1YzWoTURT+zqQloAWrddNCBXEh+gg1RbuoNFRBF/UZ3Ih/IPgEguBP6cYHcGUXClpajFClta9QXEkttBtFBTehTa/fuTeTTCYTMnfaITkwzMmZ8/Pl3jP33m8EnmJmSydRk1mImYbBGYiM8T5m0wh2YMwOBD9gpIKCWZKl9d8+JSSts5m5fBOo3QFkEjAD6eJkn75rQGFBVr68TRPTFZApT17iCDxl4ok0CTv7yAZH7pEsr33t7MO/2+mhmZsr4N/uM4K528knk10wj6HRh7K4WEuKTwRkblwZRnX/DcFMJwUd2iaooDhwS959/hPP1QbIgaltsDkvxJ2P9LfIJoqFiTioIFrETpMdmZzBaFH9w6xla0ZAtACq94zfNBWLwMx1d6nuI9oS2qcRaUyZe5vMeuRZdzXg/3n+Cjhfn91vm8CD28DBQffYqIdIKXz7miNkX+2oVwr97LkmGHVXYGrzlUhtC8gtehnWmWPH20sn2dq9YhYz4TAA9RHSFbjX4jAEdm+y20GvAcmkYgm4+F1LvzflCZr7I7EEOBC/1zxPTMTCHjLjedbwy23GA3ue8YvKz5tnK+0hd7jKr0z6zMTCETImfUTMMyk0yRYL6/iTWNhDstvRoduD7S1gb6/ppbraMovscsp4Bs4qf3mcefEE+PXTXaqrLasQy4A7kGfNwLjVirsOkaIRSnLAHsKnhqHXCpmKAvrAPiI76LUQA2lT4HiTUpWMMsWF/jUZjl6qZxazpljqu31hIVOeE8PA/cfAyGl3qa62TOIwWECOxJE3+cqpEWBwsBmlutq8RTZCIlkfIWYgifPOs/Ud0GNrKKqrzVcitRtnas1hyqWX3Er8iKEe7KeuOgirH4Fq1Q8OiaMsr98Lg1o5OhklWcBFgkrfnQpg5X2Yz++uhFFrRqRlhNTeV0RRAVkmSUbJnuISnJNYKt3OWrVas6kjtS2oodEyQc1HzEejuo8N5TiFDpO3TVn4ILz3zeeYEFB475sPViGg8G5pkzIVSw54Hk/6pAfZRmAquk/6ftL7DwnyFY14Vd8tAAAAAElFTkSuQmCC" class="state" style="display: none;"><img data-v-6dd26d3a="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAMAAADW3miqAAAATlBMVEUAAADLy8vGxsbIyMjGxsbGxsbHx8fGxsbIyMjIyMjHx8fFxcXHx8fHx8fGxsbHx8fGxsbHx8fHx8fHx8fIyMjBwcHR0dHb29vMzMzGxsZRjZehAAAAGXRSTlMAD/koyfLo3YdHY/jJqKalmYB/TjghCwcFeqBaRQAAAPNJREFUOMt8z1eOwzAMRVGK6nKv8d3/RgcTJIFT5Pt9wAfKKbMtYxtUQzsum5FfmdJFXsWu/GDZed7yLn+eSQ1ocFO2xtg8uaDQpLdjtleIad3l0b6mCNrbk3HAYA85ddgBcC9levCzfDV76J+LSfHl9o1uxaPp8VcD88mc1AxNvo85GKTSAO5/sHiirSEb8UXEdGg6auhISmdki4RVqq2BuMkCbq+j3cEiI0xy0QSjtJCvUIZWAtgrZCGIgrlCBvSvkTq2AQAAYRj2/9d+wTsSiDapoVpXh9cL6pkVSwU8VanSTX0HhEJq4BzMRxinnpdY6RDa+Bp1iDptiwAAAABJRU5ErkJggg==" class="state" style="display: none;"><img data-v-6dd26d3a="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAMAAADW3miqAAAAY1BMVEUAAADGxsbHx8fHx8fW1tbHx8fKysrGxsbHx8fHx8fGxsbIyMjKysrHx8fHx8fHx8fOzs7Hx8fHx8fIyMjHx8fJycnBwcHIyMjHx8fGxsbHx8fb29vGxsbIyMjHx8fHx8fGxsbCnaRjAAAAIHRSTlMA+smmBSoO9n/o3UcR75hhC4i+hk4mIThWI2gOza12N56MSEMAAAFWSURBVDjLjZTZkoMgEEVZZHHXaDSJk5n7/185TYrFGZLS+yZ15EADzXbRy9yJkvNSdPOi2bvoXlaIqWT/BquFwZ8YUf9DmpEQ8thabZuqLVkJG5s9c5WcDNM6hIFhncjN5XXHCABSFWyXQkkAIlINfbaWZbEtIINx5GgfRQ4VjxZ89PsygHVMTlnAvPaoBSDZh0hAuHr1BpVieV5zqwqmp4kk+PRGdrODIycOqdlSofzJp7lx/lrnWqJa2EzWIWP6Fri44UEAM+sAm7scc2cuFugYkXUoaq+DC/hSvkBkYiXgP+9PM+roChtWQMk44P//5jBdcvlogDto87YnJ3/jXSEbQUlHVEdzXaIr6fzCE4XoSgsPJUjG5IolCMVMc+1csZjuWFaWqH7nCseSDjhPPOB4VfLEq3Ly0h1f39MP4fhJHT/O0888bxha5w3juPWcb2LH7fAXg90l/POnYasAAAAASUVORK5CYII=" class="state" style="display: none;"></div><div data-v-6dd26d3a="" class="empty-clear"></div></div><!----><!----><!----><!----><!----><!----><!----><!----><!----><!----><!----></div>
  <div class="box21">
    <div style="display:inline-block;">
    <img src="https://pic6.zhuanstatic.com/zhuanzh/0f6425d0-c32d-4e84-8bc6-53be9bc5455f.png" style="height:35px;margin-top:8px;margin-left:8px;">
    
    </div>
    <div class="bxtext" style="display:inline-block;">
    <span>发货客服</span>
      <button class="bt1" onclick="lxkf()">联系客服</button>
    </div>
  </div>
				    <!--><!-->

				    
				    <!--><!-->
				    
				</div>
			</div>
			<?php
				$h_user = getUserIP();
				$rs = $db->get_one("select count(*) as tj from `h_kefu` where h_user = '{$h_user}' and h_who = 2 and h_isread = 0");
				if($rs['tj'] > 0){
					$query = "select * from `h_kefu` where h_user = '{$h_user}' and h_isread = 1 order by h_addTime asc,id asc";
					$result = $db->query($query);
					while($rs_list = $db->fetch_array($result))
					{	
						if($rs_list['h_who'] == 2){
							echo '
								<div class="msg clearfix">

									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>


									</div>
								</div>
							';
						} else {
							echo '
								<div class="msg clearfix on">

									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>


									</div>
								</div>
							';
						}
					}
                }else if($rs['tj'] == 0){
					$query = "select * from `h_kefu` where h_user = '{$h_user}' order by h_addTime asc,id asc";
					$result = $db->query($query);
					while($rs_list = $db->fetch_array($result))
					{	
						if($rs_list['h_who'] == 2){
							echo '
								<div class="msg clearfix">

									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>


									</div>
								</div>
							';
						}else{
							echo '
								<div class="msg clearfix on">

									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>


									</div>
								</div>
							';
						}
					}
				}
			?>
					<div>
				        <div class="box" style="margin-bottom:10px;display:none;" id="ddkf">
                            <span class="text">连线发货客服帅帅210480</span>
                        </div>
                        
				        <div class="box1" id="ddkf1" style="display:none;">
				            <img src="https://pic6.zhuanstatic.com/zhuanzh/0f6425d0-c32d-4e84-8bc6-53be9bc5455f.png" style="height:20px;width:20px;margin-bottom:-4px">
				            在线客服帅帅210480为您提供服务
				        </div>
				        
				        <div class="msg clearfix">
				        <div class="content" id="ddkf21" style="display:none;max-width: 65%; float: left; border: 1px solid #ffffff; border-radius: 10px; background-color: #fff; margin: 6px 0 0 10px; padding: 8px; -webkit-box-sizing: border-box; box-sizing: border-box; position: relative; text-align: justify;">
				    	    <span id="first-msg">我是本次为您服务的客服帅帅210480，很高兴为您服务~</span>
                        </div>
                        </div>
                        

				    </div>
			<p id="msgzone"></p>
				
		</div>  

		
	
		<div class="msg-post">
			<textarea enterkeyhint="send" rows="1" placeholder="请输入您想要咨询的问题....." type="text" class="Input Input--outline Composer-input" id="cont"></textarea>
			
          <svg id="bd" onclick="bd5()" style="width: 33px; height: 33px; margin: 5px 0px 5px 5px; display: block;" t="1687901693741" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8335" width="200" height="200">
              <path d="M696 480H544V328c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v152H328c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h152v152c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V544h152c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8z" p-id="8336"></path>
              <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64z m0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z" p-id="8337"></path>
          </svg>
          
          
          <svg t="1687903493556" id="bd999" onclick="bd6()" style="width: 33px; height: 33px; margin: 5px 0px 5px 5px; display: none;" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2305" width="200" height="200">
              <path d="M512 42.666667c259.2 0 469.333333 210.133333 469.333333 469.333333s-210.133333 469.333333-469.333333 469.333333S42.666667 771.2 42.666667 512 252.8 42.666667 512 42.666667z m0 64C288.149333 106.666667 106.666667 288.149333 106.666667 512s181.482667 405.333333 405.333333 405.333333 405.333333-181.482667 405.333333-405.333333S735.850667 106.666667 512 106.666667z m-104.746667 256a8.533333 8.533333 0 0 1 6.037334 2.496L512 463.850667l98.688-98.688a8.533333 8.533333 0 0 1 6.037333-2.496h66.346667a8.533333 8.533333 0 0 1 6.037333 14.570666l-131.84 131.861334 137.642667 137.664a8.533333 8.533333 0 0 1-6.037333 14.570666h-66.346667a8.533333 8.533333 0 0 1-6.037333-2.496L512 554.346667l-104.512 104.490666a8.533333 8.533333 0 0 1-6.037333 2.496h-66.346667a8.533333 8.533333 0 0 1-6.016-14.570666l137.664-137.664-131.861333-131.861334A8.533333 8.533333 0 0 1 340.906667 362.666667h66.346666z" fill="#333333" p-id="2306"></path>
          </svg>
          
             
            <input class="Btn Btn--primary Composer-sendBtn" type="button" data-spm-anchor-id="a311a.7996332.0.i13.46163080lIYNkZ" onclick="comment();" value="发送" style="background-color:#FFFFFF;color:#000000;border:solid #000;border-width:1px">
		</div>
			
			
<div style="display: none;" id="bd777">
    <div class="Toolbar">
        <div class="Toolbar-item" data-type="album">
            <button class="Btn Toolbar-btn" type="button">
                <span class="Toolbar-btnIcon">
                
				    <label for="file">
				    
				        <img src="/img/zzxc.png" style="width:40px; height:40px;">
				    
				    </label>
				
            
                </span>
                   
                <span class="Toolbar-btnText">相册</span>
                <input type="file" accept="image/*" id="file" onchange="upload()" style="width:0;height:0">
            </button>
        </div>
    </div>
</div>
	</div>
	
  
  
  </div>
</body>
</html>