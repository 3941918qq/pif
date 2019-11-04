<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SuccessExampleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="success-example-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'img_url') ?>

    <?= $form->field($model, 'ctime') ?>
    
    <?= $form->field($model, 'unique_key') ?>

    <?php // echo $form->field($model, 'utime') ?>

    <?php // echo $form->field($model, 'car_id') ?>

    <?php // echo $form->field($model, 'code_id') ?>

    <?php // echo $form->field($model, 'isvip_view') ?>

    <?php // echo $form->field($model, 'page_view') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
