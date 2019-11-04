<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$this->title = '权限设置: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index']];
$this->params['breadcrumbs'][] = '权限设置';
?>
<div class="adminuser-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="adminuser-privilege-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= Html::checkboxList("newPri", $AuthAssignmentsArray,$allPrivilegesArray);?>


        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>


