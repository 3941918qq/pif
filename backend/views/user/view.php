<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'name',
            'username',
             [
                 'attribute'=>'sex',
                 'value'=>function($model){
                        return ($model->sex == 1) ? '女':'男';
                 }
             ],
             'birthday',
//            'auth_key',
            // 'password_hash',
//            'password_reset_token',
            
            // [
            //    'attribute'=>'status',
            //     'value'=>function($model){
            //         return ($model->status==0) ? '正常': '异常';
            //     }
            // ],
            
            // 'img_url:url',
            //  [
            //      'label'=>'头像',
            //      'attribute'=>'img_url',
            //      'value'=>function($model){
            //             if(in_array($extension, ['jpg','png','gif'])){
            //                  echo '<img src="'.$model->img_url.'" alt="暂无图片"width="35%" >';
            //             }else return $model->img_url;
            //      }
            //  ],
            // 'area',
            'company',
            'address',
            'email:email',
            'score',
//            [
//                 'attribute'=>'is_vip',
//                 'value'=>function($model){
//                        return ($model->is_vip == 1) ? '是':'否';
//                 }
//             ],
            [
               'attribute'=>'created_at',
                'format'=>['date','php:Y-m-d H:i:s'],
            ],
            // [
            //    'attribute'=>'updated_at',
            //     'format'=>['date','php:Y-m-d H:i:s'],
            // ],
            'comment:ntext',
             
            //   'vip_endtime',
        ],
    ]) ?>

</div>
