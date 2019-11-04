<?php
use frontend\components\BackNavWidget;
use yii\helpers\Html;
$this->title="邀请好友";
?>
<style>
    .person{font-size:1.4rem;margin-top:15px;border:none;line-height: 32px;}
    .person-info{float:right;margin-top:25px;}
</style>
<!-- 内容 -->
<div class="container">
<div class="row">
    <div class="thumbnail" style="margin:5px 5px auto 5px;">
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2" style="padding:0;text-align:center">
            <img src="<?=$data['qrcode_url']?>" alt="140*140" class="img-circl">
            <div class="clearfix"></div>
            <div class='col-xs-6 col-sm-6 col-md-4 col-lg-4 text-center col-md-offset-2 col-lg-offset-2' > 
                <button type="button" class="btn btn-danger" id="cardList" val="<?= $data['qrcode_value']?>">复制链接</button>
            </div>
            <div class='col-xs-6 col-sm-6 col-md-4 col-lg-4 text-center'   >  
                <button type="button" class="btn btn-danger"><a href="<?= $data['qrcode_url']?>" download="img" style="color:white;">保存图片</a></button>
            </div>
        </div>
          <div class="clearfix"></div>  
            
    </div>
    <div class="thumbnail" style="margin:5px 5px auto 5px;">      
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1" style="padding:0;margin-bottom:20px;">
            <h3 style="font-size:2rem;"> 说明：</h3>     
            1.方法一：单击【复制链接】按钮，将链接信息通过微信直接发送给对方。<br/>
            2.方法二：长按图片或者点击【保存图片】保存到本地，发送图片给对方，对方收到图片后使用微信扫一扫即可。<br/>
            3.每邀请一名好友注册成功，可以获得10积分；积分说明：积分累计到一定数额会获得会员等级提升，不同的会员等级可以享受不同的福利哦！
        </div>
        <div class="clearfix"></div>  
    </div>
</div>
<div class="reminde-info">
    <span class="" aria-hidden="true">复制成功</span>
</div>
</div>
<script>
$(function(){
    $('body').css('background-color','#d43f3a');
    hideInfo();
})
// 定义一个新的复制对象                  
function copy(str){
    var save = function (e){
        e.clipboardData.setData('text/plain',str);//下面会说到clipboardData对象
        e.preventDefault();//阻止默认行为
    }
    document.addEventListener('copy',save);
    document.execCommand("copy");//使文档处于可编辑状态，否则无效
    $(".reminde-info").show();
    setTimeout(hideInfo,2000)
}
function hideInfo(){
    $(".reminde-info").hide();
}
document.getElementById('cardList').addEventListener('click',function(ev){
  console.log();
    copy(ev.target.getAttribute("val"))
})
                

</script>