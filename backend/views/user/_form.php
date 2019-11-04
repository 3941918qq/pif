<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
function getUserLevel($obj){
    if(!$obj) return 0;
    $score=$obj->score;
    if($score<100){
        return 1;
    }elseif($score>=100 && $score<500){
        return 2;
    }elseif($score>=500){
        return 3;
    }
}
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->dropDownList([ '男', '女', ]) ?>

    <div class="form-group field-user-birthday">
        <label class="control-label" for="user-sex">生日</label>
        <input type="date" class="form-control" name="User[birthday]" id="text_birth" value="<?= $model->birthday?>">

        <div class="help-block"></div>
    </div>

    <?php if($model->isNewRecord){ ?>
    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>
    <?php }?>
    
    <!-- <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true,'disabled'=>'disabled']) ?> -->
    
    <?php if($model->isNewRecord){ ?>
    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>
    <?php }?>
    
    <!-- <?= $form->field($model, 'img_url')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<!--     $form->field($model, 'is_vip')->dropDownList([ 1 => '是', 0 => '否', ])-->
    <?= $form->field($model, 'score')->textInput(['maxlength' => true]) ?>
    <div class="form-group field-user-level">
        <label class="control-label" for="user-level">会员等级</label>
        <input type="text" id="user-level" class="form-control" name="" disabled value="<?php $level=getUserLevel($model);echo yii::$app->params['view_level'][$level];?>">
        <div class="help-block"></div>
    </div>   
    <!--  $form->field($model, 'vip_endtime')->widget(DateTimePicker::className(), [
                           'name' => 'to_date',
                            'options' => ['placeholder' => ''],  //注意，该方法更新的时候你需要指定value值
                            'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd hh:ii:ss',
                                    'todayHighlight' => true
                            ]
                    ])  -->

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
