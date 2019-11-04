<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SuccessExample */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '成功案例', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="success-example-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
