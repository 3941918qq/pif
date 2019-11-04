<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
<!--    <h1><?= Html::encode($this->title) ?></h1>-->

<!--    <p>Please fill out the following fields to login:</p>-->

    <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title text-center">后台管理系统</h1>
                    </div>
                    <div class="panel-body">
                         <?php $form = ActiveForm::begin([
                             'id' => 'login-form',
//                             'options' => ['class' => 'form-horizontal Modify_pwd'],
                             'fieldConfig' => [
                                    'template' => ' <div class="form-group field-login-form-login required">
                                                        <label class="control-label" for="login-form-login">{label}:</label>
                                                            {input}
                                                            <span class="help-block" style="color:#a94442;"><span>
                                                        <div class="help-block"></div>
                                                    </div> ',
                                   'inputOptions' => ['class' => 'form-control'],
                                 ],
                             
                             ]); ?>

                            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                            <?= $form->field($model, 'password')->passwordInput() ?>

                            <?= $form->field($model, 'rememberMe')->checkbox()->label('记住密码') ?>

                            <div class="form-group">
                                <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                            </div>
                            <div id="w0"><ul class="auth-clients text-center">郑州捷安高科股份有限公司</ul></div> 

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
<!--                        <div id="w0"><h2>郑州捷安高科股份有限公司</h2></div>  -->
            </div>
    </div>
</div>
