<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '重置密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?= $form->field($model, 'pwd')->passwordInput(['autofocus' => true])->label('旧密码') ?>
                <?= $form->field($model, 'newPwd')->passwordInput()->label('新密码') ?>
                <?= $form->field($model, 'reNewPwd')->passwordInput()->label('重复新密码') ?>
                <input type="hidden" id="uid" name="ChangePass[uid]" value="<?= $uid?>">
                <div class="form-group">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary pull-right btn-block']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

