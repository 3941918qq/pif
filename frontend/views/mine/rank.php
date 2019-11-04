<?php
use frontend\components\BackNavWidget;
use yii\helpers\Html;
$this->title="我的积分";
?>
<style>
    .person{font-size:1.4rem;margin-top:15px;border:none;line-height: 32px;}
    .person-info{float:right;margin-top:25px;}
</style>
<!-- 内容 -->
<div class="container">
<div class="row">
    <div class="thumbnail" style="margin:5px;">
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 text-center" style="padding:0;color:#666;">
            <p  style="font-size:1.5rem;padding-top:20px;margin-bottom:0;">总积分</p>
            <h1 style="font-weight:900;padding:0;margin:0;line-height:4.5rem;padding-bottom:1.5rem;"><?= $score?></h1>
        </div>
          <div class="clearfix"></div>  
            
    </div>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1" style="padding:0;margin-bottom:10px;color:white;">
        <h3 style="font-size:2rem;">积分获取：</h3>
        1.邀请好友注册成功即可获取10积分。<br/>
        2.每日签到可获取5积分。
        <h3 style="font-size:2rem;">等级说明：</h3>
           用户等级积分达到对应升级门槛，则获得相应等级提升，积分永久有效。<br/>
           1.注册会员：可学习对应等级要求为注册会员及以下等级会员的课程。<br/>
           2.银牌会员：可学习对应等级要求为银牌会员及以下等级会员的课程。<br/>
           3.金牌会员：可学习对应等级要求为金牌会员及以下等级会员的课程。<br/>
            <div class="table-responsive " style="margin-top:1.5rem;">
                <table class="table table-bordered text-center">
                  <thead style="">
                    <tr>
                      <th style="text-align:center;">等级</th>
                      <th style="text-align:center;">对应等级积分</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>注册会员</td>
                      <td>0</td>
                    </tr>
                    <tr>
                      <td>银牌会员</td>
                      <td>100</td>
                    </tr>
                    <tr>
                      <td>金牌会员</td>
                      <td>500</td>
                    </tr>
                  </tbody>
                </table>
            </div>
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

