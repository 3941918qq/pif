<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminuserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '权限管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加管理员', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'username',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
            //'role',
            //'status',
            [
                'attribute'=>'created_at',
                'format'=>['date','php:Y-m-d H:i:s'],
            ],
            //'updated_at',
            'last_login_time',
            'last_login_ip',

            ['class' => 'yii\grid\ActionColumn',
             'header'=>'操作',
             'template'=>'{update} {delete} {privilege}',
             'buttons'=>[
                        'privilege'=>function ($url,$model,$key){
                             return  Html::a('<span class="glyphicon glyphicon-user"></span>', $url, ['title' => '审核','data'=>$model->id] ); 
                        },
                    ]
             
            ],
        ],
    ]); ?>
</div>
