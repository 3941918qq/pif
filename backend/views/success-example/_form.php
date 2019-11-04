<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\CodeList;
use \xj\ueditor\Ueditor;
/* @var $this yii\web\View */
/* @var $model common\models\SuccessExample */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="success-example-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'content')->widget(Ueditor::className(), [
        'style' => 'width:100%;height:400px',
        'renderTag' => true,
        'readyEvent' => 'console.log("example2 ready")',
        'jsOptions' => [
            'serverUrl' => yii\helpers\Url::to(['upload']),
            'autoHeightEnable' => true,
            'autoFloatEnable' => true
        ],
    ])?>

<!--     $form->field($model, 'content')->textarea(['rows' => 6]) -->

<!--   $form->field($model, 'img_url')->textInput(['maxlength' => true]) -->

    <?= $form->field($model, 'code_id')->dropDownList(
            CodeList::find()
            ->select(['name'])
            ->where(['code'=>2])
            ->indexBy('id')
            ->column()
    )->label('业务类别') ?>
    <?= $form->field($model, 'car_id')->dropDownList(
            CodeList::find()
            ->select(['name'])
            ->where(['code'=>1])
            ->indexBy('id')
            ->column()
    )->label('车辆类别') ?>
<!--    $form->field($model, 'isvip_view')->dropDownList([ 1 => '可见', 0 => '不可见', ] )-->
    <?= $form->field($model, 'view_level')->dropDownList(yii::$app->params['view_level'])?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>