<?php
use frontend\components\BackNavWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\components\FooterWidget;
use yii\widgets\LinkPager;

if($type=='comment'){
  $this->title="我的评论";
}else if($type=='givelike'){
  $this->title="我的点赞";
}else if($type=='history'){
  $this->title="浏览历史";
}
?>
<!-- 内容 -->
<div class="container" style="font-size:16px;">
<div class="row">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="toggle-nav" role="presentation" ><a href="#home" aria-controls="home" role="tab" data-toggle="tab">评论</a></li>
    <li class="toggle-nav" role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">点赞</a></li>
<!--    <li class="toggle-nav" role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">分享</a></li> -->
    <li class="toggle-nav" role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">历史</a></li>
  </ul>
   <input type="hidden"  value ="<?= $type?>" id="de-type">
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane " id="home">
        <div class="thumbnail">
            
         <?php if($comment){ ?>
            <?php foreach($comment as $k=>$v){?>
            <div class="caption" style="font-size:1.5rem;">  
              <div class="comment ">
                <p class="user_comment">
                    <img style="width:15%;height:50px;" src="<?= (Html::encode($v['header']) )? Html::encode($v['header']):'/img/garf.jpg'?>" alt="">
                    <span class="telinfo" style="line-height:50px;"><?= Html::encode($v['username'])?></span>                  
                </p>
                <div class="clearfix"></div>
                <p style="max-height:50px;overflow:auto;padding:3px 3px;text-indent:25px;border-radius:5px;background-color:#eee;margin-bottom:0;">
                    <?= Html::encode($v['content'])?>                  
                </p>        
              </div> 
                 <?php  if(isset($v['url'])){  ?>
                <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12" style="padding:0;">
                        <div class="thumbnail" style="margin:0;">
                              <a href="<?= Url::toRoute(['home/data-detail','dataid'=>$v['cid']])?>">
                                   <video style="width:100%; "  preload="none" poster="<?= ($v['poster'])  ?  $v['poster'] : "/img/carousel3.jpg"?>" controls>
                                      <source src="<?= $v['url']?>" type="video/mp4">
                                      <source src="<?= $v['url']?>" type="video/ogg">
                                  </video>
                                   <div class="carousel-caption mine-comment" style="padding-top:0;">
                                     <h3 class="h3-title"><?= $v['title']?></h3>
                                   </div>                                   
                              </a>
                        </div>
                 </div>                
                 <a href="<?= Url::toRoute(['home/data-detail','dataid'=>$v['cid']])?>">
                        <span><?=$v['ctime']?></span> 
                        <div class=" share " style="float:right;">
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"><?=$v['page_view']?></span>
                            <span class="glyphicon glyphicon glyphicon-heart" aria-hidden="true"><?=$v['givelike_total']?></span>
                        </div>  
                </a>
                  <?php  }else{  ?>
                    <a href="<?= Url::toRoute(['success-example/data-detail','dataid'=>$v['cid']])?>">
                        <img src="<?= $v['img_url']?>" style="width:100%;" alt="...">
                        <span><?=$v['ctime']?></span> 
                        <div class=" share " style="float:right;">
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"><?=$v['page_view']?></span>
                            <span class="glyphicon glyphicon glyphicon-heart" aria-hidden="true"><?=$v['givelike_total']?></span>
                        </div>  
                   </a>
                   <?php }?> 
               
              <div class="clearfix"></div>         
            </div> 
         <?php }}else{?>
            <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12">没有记录！</div>
          <?php }?> 
        </div>           
       <div class="footer-page"> 
        <?= LinkPager::widget([
        'pagination' => $ComPagination,]);?>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
      <div class="row1">
          <?php if($givelike){?>
          <?php foreach($givelike as $k=>$v){?>
                <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12" style="padding-top:15px;">
                  <div class="thumbnail">
                    <?php  if(isset($v['url'])){ ?>
                    <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12" style="padding:0;">
                            <div class="thumbnail" style="margin:0;">
                                  <a href="<?= Url::toRoute(['home/data-detail','dataid'=>$v['cid']])?>">
                                       <video style="width:100%; "  preload="none" poster="<?= ($v['poster'])  ?  $v['poster'] : "/img/carousel3.jpg"?>" controls>
                                          <source src="<?= $v['url']?>" type="video/mp4">
                                          <source src="<?= $v['url']?>" type="video/ogg">
                                      </video>
                                       <div class="carousel-caption mine-comment" style="padding-top:0;">
                                         <h3 class="h3-title"><?= $v['title']?></h3>
                                       </div>                                   
                                  </a>
                            </div>
                     </div>
                    <a href="<?= Url::toRoute(['home/data-detail','dataid'=>$v['cid']])?>">  
                       <p class="degist"> 
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"><?=$v['page_view']?></span>
                        <span class="glyphicon glyphicon glyphicon-heart" aria-hidden="true"><?=$v['givelike_total']?></span>
                       </p> 
                    </a >
                    <?php   }else{  ?>
                     <a href="<?= Url::toRoute(['success-example/data-detail','dataid'=>$v['cid']])?>">
                        <img src="<?= $v['img_url']?>" style="width:100%;" alt="...">
                     </a>
                      <h3 class="h3-title"><?= $v['title']?></h3>
                       <p class="degist"> 
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"><?=$v['page_view']?></span>
                        <span class="glyphicon glyphicon glyphicon-heart" aria-hidden="true"><?=$v['givelike_total']?></span>
                       </p> 
                    </a >
                   <?php }?> 
                  </div>
                </div>
          <?php }}else{?>
          <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12">没有记录！</div>
          <?php }?>
      </div>
        <div class="footer-page">
            <?= LinkPager::widget([
            'pagination' => $GivePagination,]);?>
        </div>
    </div>
<!--    <div role="tabpanel" class="tab-pane" id="messages">
        <div class="row1">
          暂无记录

      </div>
    </div>-->
    <div role="tabpanel" class="tab-pane" id="settings">
        <div class="row1">
             <?php if($history){?>
               <?php foreach($history as $k=>$v){?>
                <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12" style="padding-top:15px;">
                  <div class="thumbnail">
                      <?php  if(isset($v['url'])){ ?>
                    <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12" style="padding:0;">
                         <div class="thumbnail" style="margin:0;">
                               <a href="<?= Url::toRoute(['home/data-detail','dataid'=>$v['id']])?>">
                                    <video style="width:100%; "  preload="none" poster="<?= ($v['poster'])  ?  $v['poster'] : "/img/carousel3.jpg"?>" controls>
                                       <source src="<?= $v['url']?>" type="video/mp4">
                                       <source src="<?= $v['url']?>" type="video/ogg">
                                   </video>
                                    <div class="carousel-caption mine-comment" style="padding-top:0;">
                                      <h3 class="h3-title"><?= $v['title']?></h3>
                                    </div>                                   
                               </a>
                         </div>
                    </div>
                    <a href="<?= Url::toRoute(['home/data-detail','dataid'=>$v['id']])?>">  
                       <p class="degist"> 
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"><?=$v['page_view']?></span>
                        <span class="glyphicon glyphicon glyphicon-heart" aria-hidden="true"><?=$v['givelike_total']?></span>
                       </p> 
                    </a >
                 <?php   }else{  ?>
                     <a href="<?= Url::toRoute(['success-example/data-detail','dataid'=>$v['id']])?>">
                        <img src="<?= $v['img_url']?>" style="width:100%;" alt="...">
                      <h3 class="h3-title"><?= $v['title']?></h3> 
                       <p class="degist"> 
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"><?=$v['page_view']?></span>
                        <span class="glyphicon glyphicon glyphicon-heart" aria-hidden="true"><?=$v['givelike_total']?></span>
                       </p> 
                    </a >
                   <?php }?> 
                    
                  </div>
                </div>
          <?php }}else{?>
          <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12">没有记录！</div>
          <?php }?>

       
      </div>
    </div>
  </div>

</div>
  
</div>
<script type="text/javascript">
  $(function(){
       var type=$("#de-type").val();  
       if(type=="comment"){
           $(".toggle-nav:eq(0)").addClass("active");
           $(".tab-pane:eq(0)").addClass("active");    
           $(".tab-pane:eq(0)>a").attr("aria-expanded","true"); 
       }else if(type=="givelike"){
           $(".toggle-nav:eq(1)").addClass("active");
           $(".tab-pane:eq(1)").addClass("active"); 
           $(".tab-pane:eq(1)>a").attr("aria-expanded","true"); 
       }else if(type=="history"){
           $(".toggle-nav:eq(2)").addClass("active");
           $(".tab-pane:eq(2)").addClass("active");
           $(".tab-pane:eq(2)>a").attr("aria-expanded","true");
       }
       
     }); 
   
    </script>


