<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '评论管理', 'url' => ['index']];
$this->params['breadcrumbs'][] ='评论详情';
?>
<div class="comment-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => '用户姓名',
                'attribute' => 'u.name',
            ],
            // 'unique_key',
            'content:ntext',
             [
               'attribute'=>'type',
               'value'=>function($model){
                    return ($model->type=="com") ?'用户':'管理员';
                },
            ],
            [
               'attribute'=>'flag',
               'value'=>function($model){
                    return ($model->flag=="1") ?'已审核':'未审核';
                },
            ],
            'ctime',
        ],
    ]) ?>

</div>
