<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '权限管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = "详情";
?>
<div class="adminuser-view">

    <h1>管理员:<?= Html::encode($this->title) ?></h1>

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
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email:email',
            'role',
            'status',
            [
                'attribute'=>'created_at',
                'format' =>['date','php:Y-m-d H:i:s']
            ],
            [
                'attribute'=>'updated_at',
                'format' =>['date','php:Y-m-d H:i:s']
            ],
            'last_login_time',
            'last_login_ip',

        ],
    ]) ?>

</div>
