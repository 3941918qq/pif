<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adminuser-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

<!--    $form->field($model, 'auth_key')->textInput(['maxlength' => true]) -->

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

<!--     $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) -->

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
