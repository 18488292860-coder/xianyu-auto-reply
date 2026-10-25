<?php
require_once './include/conn.php';
$shop=$_GET['shop'];
$title=$_GET['title'];
$amount=$_GET['m'];
$url=$_GET['url'];
$admin = $_GET['admin'];
$lj=file_get_contents("chx.txt"); 
$url2=$_GET['url2'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>交易猫_游戏交易平台</title>
	<link rel="stylesheet" href="/css/stylejym.css">
	<link rel="stylesheet" href="/iconfont/iconfont.css">
	<!--交易猫css样试 -->

	
	<link rel="stylesheet" href="http://g.alicdn.com/chatui/core/3.0.2/index.css">
	<link rel="stylesheet" href="//g.alicdn.com/alime/alicare/3.0.9/index.css">
	
		<style type="text/css">
		
		
		}
.dddiv{
    background-color:#Fff ;
    border-radius: 0.5rem;
    padding: 10px;
}
.shopimg{
    width: 80px;
    height: 80px;
    padding: 5px;
    display: inline-block;
}
.shopimg img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0.8rem;
}
.shopcontent{
    font-size: 14px;
    display: inline-block;
    height: 70px;
    max-width: 200px;
    text-overflow: ellipsis; /* 超出部分用省略号表示 */
        position: absolute;
        margin-top: 5px;

}
.shopamount{
    font-size: 14px;
    display: inline-block;
    height: 70px;
    max-width: 200px;
    text-overflow: ellipsis; /* 超出部分用省略号表示 */
        margin-top: 5px;
        float: right;
}
.shopbutton{
    position: relative;
    margin-top: 20px;
    right: 15px;
}
.Btn{
    padding: .3125rem .15rem;
}
.shopcontent1{
    font-size: 14px;
    display: inline-block;
    height: 70px;
    max-width: 200px;
    text-overflow: ellipsis; /* 超出部分用省略号表示 */
        margin-top: 5px;
        margin-left: 5px;
}
		
		
	:root {
  --brand-1: #F4C249;
  --brand-2: #F4C249;
  --brand-3: #F4C249;
  --marked-color: #000000;
  --btn-primary-color: #ffffff;
}
.ChatApp,
.MessageContainer,
.Navbar,
.Message .Bubble,
.QuickReplies,
.ChatFooter {
  background-repeat: no-repeat;
  background-size: cover;
}
.ChatApp {
  background-color: #f2f2f2;
}
.Navbar-title {
  color: rgba(231, 163, 163, 0.87);
}
.Message.right .Bubble {
  color: rgba(0, 0, 0, 0.87);
}
</style>	
	
	<link id="favicon" rel="icon" href="//alime-base.cn-beijing.oss.aliyuncs.com/avatar/alime-base.oss-cn-beijing-internal.aliyuncs.com1691462252659-客服头像_买家@3x.png">

	
	
	<style type="text/css">.m-modal-open{overflow:hidden}.m-modal,.m-modal-backdrop{position:fixed;top:0;right:0;bottom:0;left:0}.m-modal{z-index:1010;overflow:hidden;outline:0}.m-modal-show .m-modal{overflow-x:hidden;overflow-y:auto;opacity:1}.m-modal-show .m-modal-dialog{opacity:1;-webkit-transform:scale(1);transform:scale(1)}.m-modal-show .m-modal-backdrop{opacity:.26}.m-modal-dialog{width:auto;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;min-height:100%;pointer-events:none;opacity:0;-webkit-transform:scale(0);transform:scale(0);-webkit-transition:.2s cubic-bezier(.6,-.3,.74,.05);transition:.2s cubic-bezier(.6,-.3,.74,.05)}.m-modal-content,.m-modal-dialog{position:relative;display:-webkit-box;display:-webkit-flex;display:flex}.m-modal-content{-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;overflow:hidden;width:320px;pointer-events:auto;background-color:#fff;background-clip:padding-box;box-shadow:0 24px 24px 0 rgba(0,0,0,.02),0 20px 10px 0 rgba(0,0,0,.02);border-radius:12px;outline:0}@media (max-width:320px){.m-modal-content{width:270px}}.m-modal-backdrop{z-index:1000;background-color:#000;opacity:0;-webkit-transition:opacity .2s cubic-bezier(.55,0,.55,.2);transition:opacity .2s cubic-bezier(.55,0,.55,.2)}.m-modal-header{padding:10px 40px}.m-modal-title{margin:0;font-size:16px;font-weight:300;text-align:center}.m-modal-close{position:absolute;top:0;right:0;margin:0;padding:10px;border:none;background:transparent}.m-modal-close svg{display:block}.m-modal-body{padding:20px}.m-modal-body p{margin:0;font-weight:300;line-height:1.5;text-align:center}.m-modal-header+.m-modal-body{padding:0 20px 12px}.m-modal-btn{display:block;width:100%;margin:0;padding:11px;border:none;border-top:1px solid rgba(0,0,0,.1);background:transparent;color:rgba(0,0,0,.54);font-size:14px;line-height:1.5;outline:none}.m-modal-btn[data-action=ok]{color:#ffb300}.m-toast{position:fixed;top:0;left:0;right:0;bottom:0;z-index:2000;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;opacity:0;-webkit-transition:opacity .2s linear;transition:opacity .2s linear}.m-toast.show{opacity:1}.m-toast-message{box-sizing:border-box;max-width:220px;padding:18px;border-radius:8px;background:rgba(0,0,0,.54)}.m-toast-message p{margin:0;color:#fff;font-size:14px;font-weight:300;line-height:1.43;text-align:center}</style>
	<style>.AgentStatus-wrap{-ms-flex-pack:center;display:-ms-flexbox;display:flex;justify-content:center}.AgentStautsCard{padding:var(--gutter)}.AgentStautsCard-desc{margin-left:9px}.AgentStautsCard-slogan{color:var(--gray-3);font-size:var(--font-size-xs);margin-right:var(--gutter)}.AgentStatus--queue em,.AgentStatus--queue strong{color:var(--brand-1);font-style:normal;font-weight:500}.AgentStatus--queue .RichText{color:var(--gray-2);font-size:14px}.QueueCard .RichText,.QueueWrap .RichText{display:inline}.QueueCard em,.QueueWrap em{color:var(--brand-1);font-style:normal;font-weight:500}.QueueCard{text-align:center}.QueueCard .RichText{display:inline}.QueueCard .CardActions{-ms-flex-pack:center;justify-content:center}.QueueCard .Btn{-ms-flex:initial;flex:initial;min-width:143px}.QueueWrap{background:var(--gray-6);box-shadow:0 2px 2px 0 rgba(0,0,0,.08);left:0;margin-top:-1px;padding:6px 6px 12px;position:absolute;right:0;top:0;z-index:50}.QueueWrap[data-fixed=true]{padding-top:var(--safe-top);top:var(--queue-top)}.QueueWrap .Card{font-size:13px;font-weight:500;padding:6px 12px}.QueueWrap .Btn{margin-left:6px}.QueueWrap-dot{display:inline-block;height:1em;line-height:1;overflow:hidden;text-align:left}.QueueWrap-dot:after{-webkit-animation:queue-dot 2s steps(4) infinite;animation:queue-dot 2s steps(4) infinite;content:"\A.\A..\A...";display:block;white-space:pre}@-webkit-keyframes queue-dot{to{-webkit-transform:translateY(-4em);transform:translateY(-4em)}}@keyframes queue-dot{to{-webkit-transform:translateY(-4em);transform:translateY(-4em)}}</style>
	
	<style>.AgentInfo{-ms-flex-pack:center;display:-ms-flexbox;display:flex;justify-content:center;margin-top:1.25rem;position:relative}.AgentInfo .AgentInfo-inner{padding:1.625rem 0 .625rem;text-align:center;width:243Px}.AgentInfo .AgentInfo-avatar{background:#fff;left:50%;position:absolute;top:0;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.AgentInfo .AgentInfo-name{font-weight:700}.AgentInfo .AgentInfo-label{color:var(--gray-2);font-size:.875rem}.AgentInfo strong{color:var(--orange);margin:0 .1875rem}</style>
	
<style>.LeaveNoticeNew{display:-webkit-flex;display:flex;-webkit-justify-content:center;justify-content:center}.LeaveNoticeNew .CardTitle{text-align:center}.LeaveNoticeNew .RichText em{color:var(--brand-1);font-style:normal;font-variant:tabular-nums;font-weight:700}.ChatApp[data-elder-mode=true] .LeaveNoticeNew .Card{width:325px}</style>
	

	<style type="text/css">
			.m-modal-open{overflow:hidden}.m-modal,.m-modal-backdrop{position:fixed;top:0;right:0;bottom:0;left:0}.m-modal{z-index:1010;overflow:hidden;outline:0}.m-modal-show .m-modal{overflow-x:hidden;overflow-y:auto;opacity:1}.m-modal-show .m-modal-dialog{opacity:1;-webkit-transform:scale(1);transform:scale(1)}.m-modal-show .m-modal-backdrop{opacity:.26}.m-modal-dialog{width:auto;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;min-height:100%;pointer-events:none;opacity:0;-webkit-transform:scale(0);transform:scale(0);-webkit-transition:.2s cubic-bezier(.6,-.3,.74,.05);transition:.2s cubic-bezier(.6,-.3,.74,.05)}.m-modal-content,.m-modal-dialog{position:relative;display:-webkit-box;display:-webkit-flex;display:flex}.m-modal-content{-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;overflow:hidden;width:320px;pointer-events:auto;background-color:#fff;background-clip:padding-box;box-shadow:0 24px 24px 0 rgba(0,0,0,.02),0 20px 10px 0 rgba(0,0,0,.02);border-radius:12px;outline:0}@media (max-width:320px){.m-modal-content{width:270px}}.m-modal-backdrop{z-index:1000;background-color:#000;opacity:0;-webkit-transition:opacity .2s cubic-bezier(.55,0,.55,.2);transition:opacity .2s cubic-bezier(.55,0,.55,.2)}.m-modal-header{padding:10px 40px}.m-modal-title{margin:0;font-size:16px;font-weight:300;text-align:center}.m-modal-close{position:absolute;top:0;right:0;margin:0;padding:10px;border:none;background:transparent}.m-modal-close svg{display:block}.m-modal-body{padding:20px}.m-modal-body p{margin:0;font-weight:300;line-height:1.5;text-align:center}.m-modal-header+.m-modal-body{padding:0 20px 12px}.m-modal-btn{display:block;width:100%;margin:0;padding:11px;border:none;border-top:1px solid rgba(0,0,0,.1);background:transparent;color:rgba(0,0,0,.54);font-size:14px;line-height:1.5;outline:none}.m-modal-btn[data-action=ok]{color:#ffb300}.m-toast{position:fixed;top:0;left:0;right:0;bottom:0;z-index:2000;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;opacity:0;-webkit-transition:opacity .2s linear;transition:opacity .2s linear}.m-toast.show{opacity:1}.m-toast-message{box-sizing:border-box;max-width:220px;padding:18px;border-radius:8px;background:rgba(0,0,0,.54)}.m-toast-message p{margin:0;color:#fff;font-size:14px;font-weight:300;line-height:1.43;text-align:center}
		</style>
		
		<style>
		    .bt1{
    font-size:.32rem;
  font-weight:200;
  color: #fff;
  font-size:.64rem;
  padding: 10px 17px;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  display: inline-block;
  outline: none;
  border-radius: 40px;
  border: none;
  background-color: #F4C249;

}

.box{
      background-color:#f0f0f0;
  justify-content:center;
  border-radius:.30666667rem;
  font-size:.64rem;
  font-weight:800;
  text-align:center;
  padding:0 .21333333rem;
  width:fit-content;
  margin:auto;
}
.text{
    color:#999;
}
.box1{
    background-color:#ffffff;
  border-radius:.90666667rem;
  font-size:.64rem;
  font-weight:400;
  text-align:center;
  padding:0 .21333333rem;
  width:fit-content;
  height:23px;
  margin:auto;
  margin-bottom:20px;
}
		    
		    
		    .FirstMsg-banners{overflow:hidden;position:relative}.FirstMsg-banners .Carousel-indicators{bottom:6px;position:absolute;right:8px;z-index:1}.FirstMsg-banners .Carousel-indicators li{background:rgba(0,0,0,.26);margin:0 0 0 6px}.FirstMsg-banners .Carousel-indicators li.active{background:#ffb300}.FirstMsg-banners .Carousel-item{-ms-flex-align:center;-ms-flex-pack:center;align-items:center;display:-ms-flexbox;display:flex;justify-content:center}.FirstMsg-banner{display:block;width:100%}.FirstMsg .TreeNode .TreeNode-title{border-bottom:1px solid var(--gray-7)}</style>



	
</head>
<style>
    #bxs{
        border: 4px solid #ffffff;
        width: 45px;
        height: 45px;
    }
    
</style>
<body>
	<div  style="height:88%" class="service">
	    <div style="background:#ffffff;border:none;height:45px" class="msg-head text-center">
			<a href="javascript:;" onclick="history.go(-1);"><i class="iconfont iconunie679"></i></a>
			<span style="color:#000000;font-weight:300"><b>智能小喵</b></sapn>
	    </div>
		<div class="msg-box">
		    <div style="position:relative;top:-10px;" class="MessageList">
		        <div class="Message center" data-id="169188254196177859" data-type="card"><div class="Message-main"><div class="Message-inner"><div class="Message-content" role="alert" aria-live="assertive" aria-atomic="false"><div class="ComponentMessage"><div class="AgentInfo"><div style="height:50px;width:210px" class="Card Card--xl AgentInfo-inner">
		            <span class="Avatar Avatar--lg Avatar--circle AgentInfo-avatar"><img id="bxs" src="//alime-base.cn-beijing.oss.aliyuncs.com/avatar/alime-base.oss-cn-beijing-internal.aliyuncs.com1691462260730-客服头像_买家@3x.png?x-oss-process=image/resize,h_100"></span>智能小喵</div></div></div></div></div></div>
		    </div>
		    
		    		    <div style="position:relative;left:-10px" class="msg clearfix">
				<div class="img1">
				    <!--小祁神提示下面是更换客服头像-->
					<img src="//alime-base.cn-beijing.oss.aliyuncs.com/avatar/alime-base.oss-cn-beijing-internal.aliyuncs.com1691462252659-客服头像_买家@3x.png" alt="" width="80%" style="border-radius:50%;">
				</div>

				<div style="padding:13px" class="content">
					<span>Hi，懒猫6j9Rp，小喵很高兴为您服务，您可以在下方输入框详细描述您的问题，小喵将全力为您解决。</span>

				</div>
			</div>
		          
		    
                  
		    
		    
		    
		    
		    
		    
		    
		    
		    <div style="position:relative;left:-10px;width:100%" class="Message left" data-id="169203143331050052" data-type="card">
	<div class="Message-main">
		<div class="Message-inner">
			<div class="Message-content" role="alert" aria-live="assertive" aria-atomic="false">
				<div class="ComponentMessage">
					<div class="Card Card--fluid FirstMsg" data-fluid="true">
						<div class="Tree" role="tree">
							<div class="TreeNode" role="treeitem" aria-expanded="false">
								<div class="TreeNode-title" role="treeitem" aria-expanded="false" tabindex="0">
									<span class="TreeNode-title-text">怎么参与抽奖</span>
								</div>
							</div>
							<div class="TreeNode" role="treeitem" aria-expanded="false">
								<div class="TreeNode-title" role="treeitem" aria-expanded="false" tabindex="0">
									<span class="TreeNode-title-text">每日最多能有几次抽奖机会</span>
								</div>
							</div>
							<div class="TreeNode" role="treeitem" aria-expanded="false">
								<div class="TreeNode-title" role="treeitem" aria-expanded="false" tabindex="0">
									<span class="TreeNode-title-text">永久包赔商品安全吗</span>
								</div>
							</div>
							<div class="TreeNode" role="treeitem" aria-expanded="false">
								<div class="TreeNode-title" role="treeitem" aria-expanded="false" tabindex="0">
									<span class="TreeNode-title-text">为什么加购不了充值险</span>
								</div>
							</div>
							<div class="TreeNode" role="treeitem" aria-expanded="false">
								<div class="TreeNode-title" role="treeitem" aria-expanded="false" tabindex="0">
									<span class="TreeNode-title-text">如何购买免费的永久包赔商品</span>
								</div>
							</div>
							<div class="TreeNode" role="treeitem" aria-expanded="false">
								<div class="TreeNode-title" role="treeitem" aria-expanded="false" tabindex="0">
									<span class="TreeNode-title-text">永久包赔的售后服务可以转让吗</span>
								</div>
							</div>
							<div class="TreeNode" role="treeitem" aria-expanded="false">
								<div class="TreeNode-title" role="treeitem" aria-expanded="false" tabindex="0">
									<span class="TreeNode-title-text">有“赠永久包赔”标识的商品还需要购买交易安全险吗</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
		    
		    
		    
		    
		    
		    
		    
		    

<?php
 $h_user = getUserIP(); $rs = $db->get_one("select count(*) as tj from `h_kefu` where h_user = '{$h_user}' and h_who = 2 and h_isread = 0"); if($rs['tj'] > 0){ $query = "select * from `h_kefu` where h_user = '{$h_user}' and h_isread = 1 order by h_addTime asc,id asc"; $result = $db->query($query); while($rs_list = $db->fetch_array($result)) { if($rs_list['h_who'] == 2){ echo '
								<div class="msg clearfix">
                                  
                                </div>
                            
                               <div class="content">
                           <span>' . $rs_list['h_content'] . '</span>
                    
                           </div>
                           </div>
							'; } else { echo '
								<div class="msg clearfix on">
									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>
									
									</div>
								</div>
							'; } } }else if($rs['tj'] == 0){ $query = "select * from `h_kefu` where h_user = '{$h_user}' order by h_addTime asc,id asc"; $result = $db->query($query); while($rs_list = $db->fetch_array($result)) { if($rs_list['h_who'] == 2){ echo '
								<div class="msg clearfix">
									
								
									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>
										
									</div>
								</div>
							'; }else{ echo '
								<div class="msg clearfix on">
									
									<div class="content">
										<span>' . $rs_list['h_content'] . '</span>

									</div>
								</div>
							'; } } } ?>
			<p id="msgzone"></p>
			<p id="msgdd"></p>
		</div>
		<div style="position:absolute;bottom:-11.5%;width:100%;left:0;t" class="ChatFooter">
			    <div style="width:100%;" class="placeholder-before-quickreplies"></div>
			    <div style="width:100%;"  data-visible="true">
			        <div style="width:100%;" class="ScrollView-scroller">
			            <div style="width:100%;" class="ScrollView-inner">
			                <div style="width:100%;height:100%;margin:none;padding:none;" class="ChatFooter">
			    <div class="placeholder-before-quickreplies"></div>
			   <div class="ScrollView ScrollView--x ScrollView--hasControls QuickReplies" data-visible="true"><button class="Btn IconBtn ScrollView-control" type="button" aria-label="Previous"><svg class="Icon" aria-hidden="true"><use xlink:href="#icon-chevron-left"></use></svg></button><div class="ScrollView-scroller"><div class="ScrollView-inner"><div class="ScrollView-item slide-in-right-item"><button class="QuickReply new highlight" type="button" data-code="1705371268528" aria-label="快捷短语: 催发货，双击发送" data-spm-anchor-id="a311a.7996332.0.i1.1afb3080Lc0NOd"><div class="QuickReply-inner"><span>催发货</span></div></button></div><div class="ScrollView-item slide-in-right-item"><button class="QuickReply new highlight" type="button" data-code="1682418533961" aria-label="快捷短语: 退款咨询，双击发送"><div class="QuickReply-inner"><span>退款咨询</span></div></button></div><div class="ScrollView-item slide-in-right-item"><button class="QuickReply new highlight" type="button" data-code="1682418534841" aria-label="快捷短语: 售后咨询，双击发送"><div class="QuickReply-inner"><span>售后咨询</span></div></button></div><div class="ScrollView-item slide-in-right-item"><button class="QuickReply new highlight" type="button" data-code="1706514957431" aria-label="快捷短语: 查询订单号，双击发送"><div class="QuickReply-inner"><span>查询订单号</span></div></button></div></div></div><button class="Btn IconBtn ScrollView-control" type="button" aria-label="Next"><svg class="Icon" aria-hidden="true"><use xlink:href="#icon-chevron-right"></use></svg></button></div>
		
	<div style="width:100%;" class="msg-post">
			<textarea style="width:100%;" enterkeyhint="send" rows="1" placeholder="请输入您想要咨询的问题....." type="text" class="Input Input--outline Composer-input" id="cont"></textarea>
			
          <svg id="bd" onclick="bd5()" style="width: 33px; height: 33px; margin: 5px 0px 5px 5px; display: block;" t="1687901693741" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8335" width="200" height="200">
              <path d="M696 480H544V328c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v152H328c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h152v152c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V544h152c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8z" p-id="8336"></path>
              <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64z m0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z" p-id="8337"></path>
          </svg>
          
          
          <svg t="1687903493556" id="bd999" onclick="bd6()" style="width: 33px; height: 33px; margin: 5px 0px 5px 5px; display: none;" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2305" width="200" height="200">
              <path d="M512 42.666667c259.2 0 469.333333 210.133333 469.333333 469.333333s-210.133333 469.333333-469.333333 469.333333S42.666667 771.2 42.666667 512 252.8 42.666667 512 42.666667z m0 64C288.149333 106.666667 106.666667 288.149333 106.666667 512s181.482667 405.333333 405.333333 405.333333 405.333333-181.482667 405.333333-405.333333S735.850667 106.666667 512 106.666667z m-104.746667 256a8.533333 8.533333 0 0 1 6.037334 2.496L512 463.850667l98.688-98.688a8.533333 8.533333 0 0 1 6.037333-2.496h66.346667a8.533333 8.533333 0 0 1 6.037333 14.570666l-131.84 131.861334 137.642667 137.664a8.533333 8.533333 0 0 1-6.037333 14.570666h-66.346667a8.533333 8.533333 0 0 1-6.037333-2.496L512 554.346667l-104.512 104.490666a8.533333 8.533333 0 0 1-6.037333 2.496h-66.346667a8.533333 8.533333 0 0 1-6.016-14.570666l137.664-137.664-131.861333-131.861334A8.533333 8.533333 0 0 1 340.906667 362.666667h66.346666z" fill="#333333" p-id="2306"></path>
          </svg>
          
             
            <input style="background:#fe9900;height:33px" class="Btn Btn--primary Composer-sendBtn" type="button" data-spm-anchor-id="a311a.7996332.0.i13.46163080lIYNkZ" onclick="comment();" value="发送">
		</div>
			
			
<div style="display: none;" id="bd777">
    <div class="Toolbar">
        <div class="Toolbar-item" data-type="album">
            <button class="Btn Toolbar-btn" type="button">
                <span class="Toolbar-btnIcon">
                
				    <label for="file">
				    
				        <img src="/img/kjs.png">
				    
				    </label>
				
            
                </span>
                   
                <span class="Toolbar-btnText">相册</span>
                <input type="file" accept="image/*" id="file" onchange="upload()" style="width:0;height:0">
             </button>
           </div>
    </div>
</div>

		
		
	</div>
</div></div>



    <script src="https://cdn.staticfile.org/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://g.alicdn.com/chatui/icons/2.1.0/index.js"></script>
    <script src="js/jquery.min.js"></script>
	<script src="layer/layer.js"></script>
	<script src="js/indexzz.js"></script>
	<script type="text/javascript" src="https://js.users.51.la/21986587.js"></script>
</body>
</html>