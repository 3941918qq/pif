<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
function getUserLevel($obj){
    if(!$obj) return 0;
    $score=$obj->score;
    if($score<100){
        return 1;
    }elseif($score>=100 && $score<500){
        return 2;
    }elseif($score>=500){
        return 3;
    }
}
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width'=>'40px']],
            'name',
            'username',                                 // 手机号
            [
                'attribute' => 'sex',
                'headerOptions' => ['width'=>'80px'],
                'filter' => ['0'=>'男','1'=>'女'],
                'value' => function($model) {
                    return ($model->sex == 0) ? '男' : '女';
                }
            ],
            'birthday',
            // [
            //     'attribute' => 'age',
            //     'header' => '年龄（岁）',
            //     'headerOptions' => ['width'=>'90px'],
            //     'value' => function($model) {
            //         return date('Y') - date('Y', strtotime($model->birthday));
            //     }
            // ],
            // 'email:email',
//          'img_url:url',
            // 'area',
            'company',
            [
                'attribute'=>'score',
                'headerOptions'=>['width'=>'60px'],
            ],
            [
                'label'=>'会员等级',
                'headerOptions'=>['width'=>'80px'],
                'value'=>function($model){
                    $level=getUserLevel($model);
                    return yii::$app->params['view_level'][$level];
                }
            ],
//            [
//               'attribute'=>'is_vip',
//               'filter'=>['0'=>'否','1'=>'是'],
//               'headerOptions' => ['width'=>'80px'],
//               'value'=>function($model){
//                    return ($model->is_vip==1) ?'是':'否';
//                },
//            ],
            // 'vip_endtime',
            [
                'attribute'=>'created_at',
                'format'=>['date','php:Y-m-d H:i:s'],
            ],
                      
            ['class' => 'yii\grid\ActionColumn',
             'header'=>'操作',   
            ],
        ],
    ]); ?>
</div>
