<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CodeList;
/* @var $this yii\web\View */
/* @var $model common\models\SuccessExample */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '成功案例', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="success-example-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定要删除这个条目吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute'=>'content',
                'format'=>'html',
            ],
             [
               'attribute'=>'code_id',
               'value'=>function($model){
                  return   $car=CodeList::findOne([$model->code_id])->name;
                },
            ],
             [
                
               'attribute'=>'car_id',
               'value'=>function($model){
                    $car=CodeList::findOne([$model->car_id]);
                    return $car->name;
                },
            ],
            'ctime',
            'utime',  
//             [
//                 'attribute'=>'isvip_view',
//                 'value'=>function($model){
//                    return ($model->isvip_view==1) ? '可见' : '不可见' ;
//                 }
//             ],
            // 'unique_key',
            'page_view',
            [
                 'attribute'=>'view_level',
                 'value'=>function($model){
                    return yii::$app->params['view_level'][$model->view_level];
                 }
            ],         
        ],
    ]) ?>

</div>
