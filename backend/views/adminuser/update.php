<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$this->title = '更新管理员: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Adminusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="adminuser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
