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
     <?=$form->field($model, 'username')->textInput(['placeholder'=>'请输入新号码'])->label("新号码")?>        
    <div class="form-group text-center">
        <div class="col-sm-12 col-xs-12">
            <?= Html::submitButton('保&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;存', ['class' => 'btn btn-default form-control']) ?>
        </div>
    </div>
   
    <?php ActiveForm::end() ?>

</div>

