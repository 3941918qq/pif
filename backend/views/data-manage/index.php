<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CodeList;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DataManageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品中心';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-manage-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('增加', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width'=>'40px']],
            [
                'attribute'=>'title',
                'headerOptions' => ['minWidth'=>'200px'],
                'value'=>  function ($model){
                    $content=strip_tags($model->title);
                    return (strlen($content) > 40) ? mb_substr($content, 0, 40,'utf-8').'...' :$content;
                }
            ],
            // [
            //     'label'=>'视频地址',
            //     'attribute'=>'url',
            //     'value'=>  function ($model){
            //         $content=strip_tags($model->url);
            //         return (strlen($content) > 25) ? mb_substr($content,0,25).'...' :$content;
            //     }
            // ],
            // [
            //     'attribute'=>'content',
            //     'value'=>  function ($model){
            //         $content=strip_tags($model->content);
            //         return (strlen($content) > 25) ? mb_substr($content,0,25).'...' :$content;
            //     }
            // ],
            [
               'attribute'=>'type',
               'headerOptions' => ['width'=>'100px'],
               'filter'=>['video'=>'视频','text'=>'文档'],
               'value'=>function($model){
                    return ($model->type=='video') ?'视频':'文档';
                },
            ],
            
            [
                'label'=>'业务类别',
                'attribute'=>'code_id',
                'headerOptions' => ['width'=>'100px'],
                'value'=>'code.name',
                'filter'=>  CodeList::find()
                           ->select(['name','id'])
                           ->where(['code'=>2])
                           ->indexBy('id')
                           ->column()
            ],
            [
                'label'=>'车辆类别',
                'attribute'=>'car_id',
                'headerOptions' => ['width'=>'100px'],
                'value'=>'car.name',
                'filter'=>  CodeList::find()
                           ->select(['name','id'])
                           ->where(['code'=>1])
                           ->indexBy('id')
                           ->column()
            ],
//            [
//               'attribute'=>'isvip_view',
//               'headerOptions' => ['width'=>'120px'],
//               'filter'=>['0'=>'不可见','1'=>'可见'],
//               'value'=>function($model){
//                    return ($model->isvip_view==1) ?'可见':'不可见';
//                },
//                // 'contentOptions'=>['class'=>'col-md-4']
//            ],
            [
               'attribute'=>'view_level',
               'headerOptions' => ['width'=>'120px'],
               'filter'=>yii::$app->params['view_level'],
               'value'=>function($model){
                    return yii::$app->params['view_level'][$model->view_level];
                },
                // 'contentOptions'=>['class'=>'col-md-4']
            ],
            [
               'attribute'=>'is_top',
               'headerOptions' => ['width'=>'120px'],
               'filter'=>['0'=>'不展示','1'=>'展示'],
               'value'=>function($model){
                    return ($model->is_top==1) ?'展示':'不展示';
                },
                // 'contentOptions'=>['class'=>'col-md-4']
            ],
            [ 
                'attribute' => 'page_view', 
                'headerOptions' => ['width'=>'80px'],
            ],
            [
                'attribute'=>'ctime',
                'headerOptions' => ['width'=>'160px'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width'=>'80px'],
                'header'=>'操作',
            ],
        ],
    ]); ?>
</div>
