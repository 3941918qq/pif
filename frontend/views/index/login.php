<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title="登录页";
?>
<div id="carousel_1" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carousel_1" data-slide-to="0" class="active"></li>
        <li data-target="#carousel_1" data-slide-to="1"></li>
        <li data-target="#carousel_1" data-slide-to="2"></li>
    </ol>   
    <div class="carousel-inner" role="listbox" >
        <div class="item active">
            <img class="login-nav-img" src="/img/carousel1.jpg" alt="First slide" >
        </div>
        <div class="item">
            <img class="login-nav-img" src="/img/carousel2.jpg" alt="Second slide" >
        </div>
        <div class="item">
            <img  class="login-nav-img" src="/img/carousel3.jpg" alt="Third slide" >
        </div>
    </div>
    <a class="left carousel-control" href="#carousel_1" role="button" data-slide="prev"> 
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    </a>
    <a class="right carousel-control" href="#carousel_1" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    </a>
</div>

<div class="container login-back">
   <?php $form = ActiveForm::begin([
        'id' => 'form_login',
        'options' => ['class' => 'form-horizontal'],
       'fieldConfig' => [
                    'template' => ' <div class="col-sm-12 col-xs-12">
                                        <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">{label}</span>
                                          {input}
                                         </div>
                                    </div>    
                                   <div class="col-sm-12 col-xs-12 text-center">{error}</div>',
                    'inputOptions' => ['class' => 'form-control'],
                   'labelOptions' => ['style' => 'margin:0;'],
                ],
    ]) ?>
     <?=$form->field($model, 'username')->textInput(['placeholder'=>'请输入手机号码'])->label("手机号")?>
     <?=$form->field($model, 'code',[
         'template'=>'<div class="col-sm-12 col-xs-12">
                        <div class="input-group">
                               <div class="input-group-addon">{label}</div>
                                {input}
                                <span class="input-group-btn" style="width:15%;">
                                    <button class="btn btn-default" type="button" style="width:100%;" onclick="sendCode(this);">获取</button>
                                 </span>
                        </div>
                     </div>
                     <div class="col-sm-12 col-xs-12 text-center">{error}</div>',
        'inputOptions' => ['style' => 'height:36px;'],
         ])->textInput(['placeholder'=>'请输入短信验证码'])->label("验证码")?>
    
    <div class="form-group text-center" >
        <div class="col-sm-12 col-xs-12">
            <?= Html::submitButton('登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录', ['class' => 'btn btn-default form-control', 'id' => 'btn_ok']) ?>
        </div>
    </div>
   
    <?php ActiveForm::end() ?>

    <div class="navbar-fixed-bottom text-center"  id="footer">
        <img src="/img/footer.png" height="20px" alt="捷安高科" style="margin-bottom: 15px;">
    </div>
</div>
<script>
    var height = $(window).height();
    $(window).on('resize', function () {
        if ($(window).height() < height) {
            $(".navbar-fixed-bottom").hide();
        } else {
            $(".navbar-fixed-bottom").show()
        }
    });
</script>
<script type="text/javascript" src="/js/login.js"></script>