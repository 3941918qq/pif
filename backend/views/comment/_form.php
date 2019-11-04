<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'u_id')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'unique_key')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6,'readonly'=>'readonly']) ?>

<!--    $form->field($model, 'type')->dropDownList([ 'rep' => '回复者', 'com' => '评论者', ], ['prompt' => '']) -->

    <?= $form->field($model, 'flag')->dropDownList([ '1' => '已审核', '0' => '未审核', ]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
