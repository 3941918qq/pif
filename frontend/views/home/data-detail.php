<?php
use frontend\components\BackNavWidget;
use yii\helpers\Html;
$this->title="详情页";
?>
<!-- 内容 -->
<div class="container" >
<div class="row">
  <h3 class="text-center" style="margin:2px auto;padding:5px;font-size:1.8rem;padding-top:20px;"><?= Html::encode($model->title) ?></h3>
  <div class="col-sm-12 col-md-12" style="padding:0;">
    <div class="thumbnail">
             <video style="width:100%; " id="video" webkit-playsinline playsinline 
              poster="<?php preg_match('<img.*?src="(.*?)">',$model->content,$match); 
                        if(isset($match[1])){ echo $match[1];}else{ echo '/img/carousel3.jpg';}?>" controls autoplay muted loop>
                <source src="<?= $model->url?>" type="video/mp4">
                <source src="<?= $model->url?>" type="video/ogg">
            </video>
      <div class="caption" style="padding-bottom:50px;"> 
        <h3>用户评论</h3>
         <?php if(!empty($comment)){ ?>
          <?php foreach($comment as $k=>$v){ ?>
                <div class="comment user_comment" style="border-bottom:1px solid #ccc;">
                
                      <img class="user-head" src="<?= ($v['img_url']) ? $v['img_url'] :'/img/garf.jpg' ?>" alt="">
                      <span  class="user-subinfo">用户***<?= substr($v['username'],7,10)?></span>             
                      <p  class="comment-content"><?= Html::encode($v['content']) ?></p>
                      <div class="clearfix" style="padding:0;margin:0;"></div>
                      <span class="time-view" ><?= $v['ctime'] ?></span>
                      <div class="clearfix" ></div>
                      <?php if(!empty($v['adminRep'])){ ?>
                        <?php foreach($v['adminRep'] as $k1=>$v1){ ?>
                      
                              <!-- <img class="admin-img" src=""alt="图片无法显示"> -->
                              <p  class="admin-comment-content"><span style="color:#3398d1;">管理员:</span><?= Html::encode($v1['content']) ?></p>
                              <div class="clearfix"></div>
                       <!--       <span class="time-view" style="float:right;padding:0;margin:0;font-size:1.2rem;"><?= $v1['ctime'] ?></span> -->
                        <?php }?>
                      <?php }?>
                                                        
                </div> 
         <?php }}else{?>
                <div class="comment table-bordered">
                  <p class="text-center" style="padding-top:5px;">
                       暂时还没有评论，快来留下您的宝贵想法和建议吧:)
                  </p>

                </div> 
         <?php }?>

        
      </div>
    </div>
  </div>
</div>
  
</div>
<!-- footer -->
<footer class="navbar navbar-fixed-bottom navbar-default" role="navigation" style="padding-top:10px;">
    <div class="form-group col-xs-6 col-sm-6 col-md-4 col-lg-4 comment-text-put" style="margin-bottom: 10px;">
     <input type="text" class="form-control" placeholder="发表评论..." value ="" aria-describedby="basic-addon2">
     <input type="hidden"  value ="<?= $model->unique_key?>" id="unique-key">
     <input type="hidden"  value ="<?= $isCollect?>" id="is-collect">
     <input type="hidden"  value ="<?= Yii::$app->user->isGuest?>" id="auth">
    </div>
    <div class="form-group  col-xs-6 col-sm-6 col-md-4 col-lg-4 share" style="margin-bottom: 10px;">
       <button type="button" class="btn btn-primary btn-sm" id="commentsub" onclick="subcomment(this)">提交</button>
        <span class="glyphicon glyphicon-eye-open" aria-hidden="true" ><?= $model->page_view?><span id="fade-addone"  style="color:#c4271d;position:absolute;right:-5px;bottom:22px;font-family:normal;"> +1</span>
        </span>
        <span class="glyphicon glyphicon glyphicon-heart "  name ="hearts" aria-hidden="true" id="heart"><?= $model->givelike_total?></span>
    </div>

</footer>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script> 
<script type="text/javascript">
//微信对于自动播放的支持
    document.getElementById('video').play(); 
    document.addEventListener("WeixinJSBridgeReady", function () { 
        document.getElementById('video').play(); 
    }, false);
    $(function(){
        var iscollect=$("#is-collect").val();
        var uniquekey=$("#unique-key").val();
        if(iscollect>0){
            $('#heart').addClass('heart-click');
        }
        $("#fade-addone").fadeOut(3000);
        $.post("/home/add-pageview", { uniquekey:uniquekey },
            function(data){             
               if(data.message>0){

               }
            });
    })
    function subcomment(jump){
        var content=$.trim($("#commentsub").parent('div').prev().children().val());
        var uniquekey=$("#unique-key").val();
        if(content!=""){
            checkAuth();
            if(content.length>=200){
                alert("评论字数不得超过200字。");
                return false;
            }
            $.post("/home/subcomment", { content: content,uniquekey:uniquekey },
            function(data){             
               if(data.message>0){
                   alert('感谢您的参与，评论审核过后方可查看。');
                   window.location.reload();
               }
            });
        }else{
            alert("评论内容不能为空");
            return false;
        }                      
    }
     $('#heart').click(function(){
         var has=$('#heart').hasClass('heart-click');
         var uniquekey=$("#unique-key").val();
         checkAuth();
         if(has){           
             var flag='-1';
             $('#heart').removeClass('heart-click');
         }else{
             var flag='1';
             $('#heart').addClass('heart-click');
         }
         $.post("/home/toggle-collect", { flag: flag,uniquekey:uniquekey },
            function(data){  
                console.log(data);
               if(data.message>0){
                   
                   window.location.reload();
               }
            });
     })

    
</script>




          

