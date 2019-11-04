<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CodeList;
/* @var $this yii\web\View */
/* @var $model common\models\DataManage */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '产品中心', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-manage-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定删除此条内容吗?',
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
                'label'=>'url',
                'attribute'=>'url',
            ],
//            'url:url',
            [
               'attribute'=>'url',
               'value'=>function($model){
                    $extension=pathinfo($model->url)['extension'];
                    if(in_array($extension, ['mp4','webm','ogg'])){
                        echo \wbraganca\videojs\VideoJsWidget::widget([
                             'options' => [
                                 'class' => 'video-js vjs-default-skin vjs-big-play-centered',
                                  //'poster' => "http://www.videojs.com/img/poster.jpg",
                                 'controls' => true,
                                 'preload' => 'auto',
                                 'width' => '970',
                                 'height' => '400',
                             ],
                             'tags' => [
                                 'source' => [
                                     ['src' => $model->url, 'type' => 'video/mp4'],
                                     // ['src' => '$model->url', 'type' => 'video/webm']
                                 ],
                                 'track' => [
                                     // ['kind' => 'captions', 'src' => 'http://vjs.zencdn.net/vtt/captions.vtt', 'srclang' => 'en', 'label' => 'English']
                                 ]
                             ]
                         ]);
                    }else if(in_array($extension, ['jpg','png','gif'])){
                         echo '<img src="'.$model->url.'" alt="暂无图片"width="40%" >';
                    }else return $model->url;
                
               }
            ],
            [
               'attribute'=>'content',
               'format'=>'html'
            ],
             [
                 'attribute'=>'type',
                 'value'=>function($model){
                    return ($model->type=='video') ? '视频' : '文档' ;
                 }
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
//            [
//                 'attribute'=>'isvip_view',
//                 'value'=>function($model){
//                    return ($model->isvip_view==1) ? '可见' : '不可见' ;
//                 }
//             ],
            // 'unique_key',
            'page_view',
            [
                 'attribute'=>'is_top',
                 'value'=>function($model){
                    return ($model->is_top==1) ? '展示' : '不展示' ;
                 }
             ],
            [
                 'attribute'=>'view_level',
                 'value'=>function($model){
                    return yii::$app->params['view_level'][$model->view_level];

                 }
            ],
            'ctime',
            'utime',
        ],
    ]) ?>

</div>
