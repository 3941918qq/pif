<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title="提交";
?>
<style type="text/css">
    .pop-area.hide {
        width: -webkit-calc(100% - 20px);
        margin: 0 0 0 10px;
        opacity: 0;
        pointer-events: none;
    }
    .pop-area{
        overflow: hidden;
/*        box-shadow: 0 1px 5px rgba(0,0,0,.2);*/
        background: #fff;
        position: absolute;
        width: 70%;
        margin-left:22%;
        border:1px solid #ccc;
        border-radius: 3px;
        z-index: 150;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        height:150px;
        overflow:auto;
        padding-left:10px;
    }
    .pop-area>li{
        list-style: none;
        line-height:24px;
    }
</style>
<div class=" banner">
    <img class="login-nav-img" src="/img/banner.jpg" width="100%">
</div>
<div class="container regist-back">
     <?php $form = ActiveForm::begin([
        'id' => 'form_register',
        'options' => ['class' => 'form'],
       'fieldConfig' => [
                    'template' => ' <div class="input-group">
                                        <div class="input-group-addon">{label}</div>
                                       {input}
                                   </div>  
                                   <div class="col-sm-12 col-xs-12 text-center">{error}</div>',
                    'inputOptions' => ['class' => 'form-control'],
                   'labelOptions' => ['style' => 'margin:0;'],
                ],
    ]) ?>
    
    <?=$form->field($model, 'name')->textInput(['placeholder'=>'请输入您的姓名'])->label("姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名")?>
   
    <div class="form-group text-center">
            <div class="btn-group" role="group">
                <label class="radio-inline">
                    <input type="radio" class="btn btn-primary" value="0" name="RegistForm[sex]" checked>男
                </label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label class="radio-inline">
                    <input type="radio" class="btn btn-primary" value="1" name="RegistForm[sex]" >女
                </label>

           </div>
        </div>
    <div class="form-group">
        <div class="input-group" >
            <div class="input-group-addon">
                <label for="text_birth" style="margin: 0px;">出生日期</label>
            </div>
            <input type="date" class="form-control" name="RegistForm[birthday]" id="text_birth" value="1990-01-01">
        </div>
    </div>
    
    <?=$form->field($model, 'company')->textInput(['placeholder'=>'请输入您的单位地址','id'=>'company-search'])->label("所属单位")?>
    <div class="pop-area suggestion hide" data-ext-sum-data="strategy=s_mtt_plain_ctr&amp;type=&amp;id="></div>
    
    <div class="form-group text-center" style="padding-bottom:75px;" >
        <div class="col-xs-12">
              <?= Html::submitButton('提&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;交', ['class' => 'btn btn-default form-control','id'=>'btn_ok']) ?>
        </div>
    </div> 

   
    <?php ActiveForm::end() ?>

    <div class="navbar-fixed-bottom text-center" >
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
<script type="text/javascript" src="/js/regist.js"></script>