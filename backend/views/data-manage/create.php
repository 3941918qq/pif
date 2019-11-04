<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DataManage */

$this->title = '添加产品';
$this->params['breadcrumbs'][] = ['label' => '产品中心', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-manage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
