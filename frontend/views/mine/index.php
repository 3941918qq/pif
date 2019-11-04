<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use frontend\components\FooterWidget;
use frontend\components\BackNavWidget;
$this->title="我的";
?>
<!-- BackNavWidget::widget()-->
<!-- 内容 -->
<div class="container" style="font-size:16px;background-color:#eee;">
<div class="row" >
 
    <div class="thumbnail gray-back">

        <img src="<?= (!Yii::$app->user->isGuest )? Html::encode($model->img_url):'/img/youke.png'?>" alt="140*140" class="img-circle" style="width:20%;margin:1rem;float:left;">        
        <div style="width:35%;float:left;margin:1rem;">
             <?php if (Yii::$app->user->isGuest){ ?>
                 <a href="/index/login"><button type="button" class="btn btn-link">登录</button><img src="/img/level_0.png" class="level"></a>
             <?php }else{ ?>
                 <p style="padding-top:7px;font-size:1.5rem;"> <?= substr($model->username,0,3).'****'.substr($model->username,7)?></p>
                 <a href="<?= Url::toRoute(['mine/rank','score'=>$model->score])?>" > <img src="/img/level_<?= $level ?>.png" class="level"></a>
             <?php }?>                             
        </div>
        <div style="width:28%;float:left;margin-top:2.5rem;position: relative;">
            <button id="sign-desk" type="button" class="btn btn-default btn-sm" style="border-radius:20px;width:80%;border-color:#d9534f;color:#d9534f;" onclick="signdesk()" >签到</button>
            <p class="hidden score-add-toggle">积分+5</p>
        </div>
        <div class="clearfix"></div>
    </div>
     <input type="hidden"  value ="<?= Yii::$app->user->isGuest?>" id="auth">
    <div class="thumbnail gray-back" style="font-size:14px;margin-bottom:3px;">     
        <ul class="nav nav-pills">
        <div class="disk col-xs-4 col-sm-4 col-md-4 col-lg-4">
          <li role="presentation" class="active text-center">
            <a href="<?= Url::toRoute(['mine/mylike','type'=>'comment'])?>">我的评论</a>
          </li>
        </div>
        <div class="disk col-xs-4 col-sm-4 col-md-4 col-lg-4">
          <li role="presentation" class="text-center"><a href="<?= Url::toRoute(['mine/mylike','type'=>'givelike'])?>">我的点赞</a></li>
        </div>
<!--         <div class="disk col-xs-3 col-sm-3 col-md-3 col-lg-3">
          <li role="presentation" class="text-center"><a href="<?= Url::toRoute(['mine/mylike','type'=>'share'])?>">我的分享</a></li>
        </div>-->
        <div class="disk col-xs-4 col-sm-4 col-md-4 col-lg-4">
          <li role="presentation" class="text-center"><a href="<?= Url::toRoute(['mine/mylike','type'=>'history'])?>">浏览历史</a></li>
        </div> 
      </ul> 

    </div>   
    <ul class="list-group infomation" style="font-size:1.4rem;margin-bottom:4px;">
        <a href="<?= Url::toRoute(['mine/myinfo'])?>" class="list-item">我的资料<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
        <a href="<?= Url::toRoute(['mine/completeinfo'])?>" class="list-item"> 完善资料<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
        <a href="<?= Url::toRoute(['mine/changetel'])?>" class="list-item">更换手机<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
        <a href="<?= Url::toRoute(['mine/share'])?>" class="list-item">邀请好友<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
        <a href="<?= Url::toRoute(['mine/aboutus'])?>" class="list-item">关于我们<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
    </ul> 
    <div class="thumbnail "style="width:100%;margin-bottom:0px;"> 
<!--         <p class="text-center" style="line-height:3.5rem;color:#ea0000;margin:0;font-size:1.4rem;" onclick="logout()">退出登录</p> -->
         <?php if (!Yii::$app->user->isGuest){ ?>
                   <button type="button" class="btn btn-danger  btn-block" onclick="logout()">退出登录</button>
         <?php }?>
         
    </div>
  </div>
<!--  <div class="mine-hide-clear"></div>-->
  
</div>

<!-- footer -->
<?= FooterWidget::widget()?>
<script type="text/javascript">
    $(function(){
         $.post("/mine/issign", {},
            function(data){             
               if(data.message>0){
                    $("#sign-desk").attr("disabled",true);
                    $("#sign-desk").css({"border-color":"#ccc","color":'#333'});
                    $("#sign-desk").text("已签到");
               }
            });
    })
    function signdesk(){
        checkAuth();
        $.post("/mine/signdesk", {},
            function(data){             
               if(data.message=='success'){
                    $("#sign-desk").attr("disabled",true);
                    $(".score-add-toggle").removeClass('hidden');
                    $(".score-add-toggle").fadeOut(3000);
                    $("#sign-desk").css({"border-color":"#ccc","color":'#333'});
                    $("#sign-desk").text("已签到");
               }
            });
    }
</script>