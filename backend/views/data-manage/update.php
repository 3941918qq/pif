<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DataManage */

$this->title = '产品中心: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '添加产品', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="data-manage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
