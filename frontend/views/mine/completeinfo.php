<?php
use frontend\components\BackNavWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title="完善资料";
?>
<div class="container" style="font-size:16px;padding-bottom:30px;">
    
    <?php $form = ActiveForm::begin([
        'id' => 'form_register',
        'options' => ['class' => 'form','enctype' => 'multipart/form-data'],
       'fieldConfig' => [
                    'template' => ' <div class="input-group">
                                        <div class="input-group-addon">{label}</div>
                                       {input}
                                   </div>  
                                   <div class="col-sm-12 col-xs-12 text-center">{error}</div>',
                    'inputOptions' => ['class' => 'form-control'],
                   'labelOptions' => ['style' => 'margin:0;font-weight:normal;'],
                ],
    ]) ?>
    <div class="col-sm-12 text-center" style="margin-top: 15px; margin-bottom: 15px;">
        <img src="<?= ($modelUser->img_url) ? $modelUser->img_url : '/img/garf.jpg' ?>" class="img-circle" width="130px" height="130px" id="show">
    </div>
    <div class="col-sm-12 text-center" style="margin-top: 15px; margin-bottom: 15px;">
        <a href="#" class="a-upload">
            <button type="button" class="btn" style="background-color:#bd3333;color:white;" id="upload-picture">更换头像</button>

            <input id='upload-input' accept='image/*' multiple type='file' onchange='auto()' name='RegistForm[imageFile]' style='display:none'>
        </a>
    </div>
    
    <?=$form->field($model, 'name')->textInput(['placeholder'=>'请输入您的姓名','value'=>$modelUser->name])->label("姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名")?>    
    <div class="form-group text-center">
        <div class="btn-group" role="group">
            <input type="hidden" value="<?=$modelUser->sex?>"  id="sex">
            <label class="radio-inline">
                <input type="radio" class="btn btn-primary" value="0" name="RegistForm[sex]" id="men">男
            </label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label class="radio-inline">
                <input type="radio" class="btn btn-primary" value="1" name="RegistForm[sex]"  id="women">女
            </label>

       </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">出生日期</div>
            <input type="date" class="form-control" name="RegistForm[birthday]" id="text_birth" value="<?= $modelUser->birthday?>">
        </div>
    </div>
    <?=$form->field($model, 'area')->textInput(['placeholder'=>'请输入您所在地市','value'=>$modelUser->area])->label("所在地区")?>
    
    <?=$form->field($model, 'company')->textInput(['placeholder'=>'请输入您的公司/学校','value'=>$modelUser->company])->label("所在单位")?>
    
    <?=$form->field($model, 'address')->textInput(['placeholder'=>'请输入单位地址','value'=>$modelUser->address])->label("单位地址")?>
    
    <?=$form->field($model, 'email')->textInput(['value'=>$modelUser->email])->label("邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱")?>
    
    <div class="form-group text-center" style="padding-bottom:10px;">
        <div class="col-xs-12">
              <?= Html::submitButton('保&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;存', ['class' => 'btn btn-default form-control','id'=>'btn_ok']) ?>
        </div>
    </div> 
    
    <?php ActiveForm::end() ?>

</div>
<script>  
    $(function(){
       if($("#sex").val()=="1") {
           $('#women').attr('checked', 'true');
       }else{
           $('#men').attr('checked', 'true');
       }
    })
     $("#upload-picture").click(function(){    
             $("#upload-input").click();                  
       
     }); 
     
     function auto(){
        var r= new FileReader();
        f=document.getElementById('upload-input').files[0];           
        r.readAsDataURL(f);
        r.onload=function (e) {
           document.getElementById('show').src=this.result;
        };
    }

</script>


