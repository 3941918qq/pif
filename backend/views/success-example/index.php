<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CodeList;
use common\models\User;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SuccessExampleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '成功案例';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="success-example-index">

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
                    return (strlen($content) > 42) ? mb_substr($content, 0,42,'utf-8').'...' :$content;
                }
            ],
            // [
            //     'attribute'=>'content',
            //     'value'=>  function ($model){
            //         $content=strip_tags($model->content);
            //         return (strlen($content) > 23) ? mb_substr($content,0,23).'...' :$content;
            //     }
            // ],
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
            [ 'attribute' => 'page_view', 'headerOptions' => ['width'=>'80px']],
            [
                'attribute'=>'ctime',
                'headerOptions' => ['width'=>'80px'],
            ],
//             [
//                 'label'=>'增加人',
//                 'attribute'=>'userid',
//                 'headerOptions' => ['width'=>'100px'],
//                 'value'=>'adminuser.username',
//                 'filter'=>  User::find()
//                            ->select(['username','id'])
//                         //    ->where(['code'=>1])
//                            ->indexBy('id')
//                            ->column()
//             ],
            ['class' => 'yii\grid\ActionColumn', 'header'=>'操作', 'headerOptions' => ['width'=>'80px'],],
        ],
    ]); 
   
    
    ?>
</div>
