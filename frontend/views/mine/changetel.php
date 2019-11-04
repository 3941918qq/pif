<?php
use frontend\components\BackNavWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title="更换手机";
?>
<div class="container" style="font-size:16px;">
    
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
                                <span class="input-group-btn">
                                    <button class="btn btn-default " type="button" style="width:100%;" onclick="sendCode(this);">获取</button>
                                 </span>
                        </div>
                     </div>
                     <div class="col-sm-12 col-xs-12 text-center">{error}</div>',
        'inputOptions' => ['style' => 'height:36px;'],
         ])->textInput(['placeholder'=>'请输入短信验证码'])->label("验证码")?>
    
    <div class="form-group text-center">
        <div class="col-sm-12 col-xs-12">
            <?= Html::submitButton('提&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;交', ['class' => 'btn btn-danger form-control']) ?>
        </div>
    </div>
   
    <?php ActiveForm::end() ?>

</div>
<script>  
function sendCode(jump){
       var tel=$("#loginform-username").val();
       var pattern = /^1[345789]\d{9}$/;   
       if(pattern.test(tel)){
           $.post("/mine/send-msg", { tel: tel },
           function(data){
              if(data=='200'){
                  alert('发送成功');
              }
           });
       }else{
           alert('请输入正确的手机号码！');
           return false;
       }
       settime(jump);      
   }

</script>




