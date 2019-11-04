<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\SuccessExample;
use common\models\DataManage;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>
        <?= Html::a('Creat Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width'=>'40px']],
            // 'u_id',
            [
                'label' => '用户名称',
                'attribute' => 'u_id',
                'headerOptions' => ['width'=>'120'],
                'value' => 'u.name',
                'filter' => User::find()->select(['name'])->indexBy('id')->column()
            ],
            [
                'label'=>'产品标题',
                'attribute'=>'title',
                'value'=>function($model){
                        $search=SuccessExample::findOne(['unique_key'=>$model->unique_key]);
                        if($search){
                            return $search->title;
                        }else{
                            $data=DataManage::findOne(['unique_key'=>$model->unique_key]);
                            return $data->title;
                        }
                }
            ],
            // 'unique_key',
            //'content:ntext',
            [
                'attribute'=>'content',
                'value'=>  function ($model){
                    $content=strip_tags($model->content);
                    return (strlen($content) > 21) ? mb_substr($content, 0 , 21 ,'utf-8').'...' :$content;
                }
            ],
            // [
            //    'attribute'=>'type',
            //    'filter'=>['com'=>'用户','rep'=>'管理员'],
            //    'value'=>function($model){
            //         return ($model->type=="com") ?'用户':'管理员';
            //     },
            //     // 'contentOptions'=>['class'=>'col-md-2']
            // ],
            [
               'attribute'=>'flag',
               'headerOptions' => ['width'=>'120px'],
               'filter'=>['1'=>'已审核','0'=>'未审核'],
               'value'=>function($model){
                    return ($model->flag=="1") ?'已审核':'待审核';
                },
               'contentOptions'=>function($model){
                    return ($model->flag==0) ? ['class'=>'bg-danger'] :'';
               }
            ],
            [
                'attribute'=>'ctime',
                'headerOptions' => ['width'=>'160px'],
            ],
            [   'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {delete} {approve} {response}',
                'headerOptions' => ['width'=>'80px'],
                'header'=>'操作',
                'buttons'=>[
                    'approve'=>function($url,$model,$key){
                           return \yii\bootstrap\Html::a("<span  class='glyphicon glyphicon-check'></span>",'#',[
                          'data-toggle'=>'modal' ,'data-target'=>'#approveModal'.$model->id,
                          'onclick'=>'hiddenId(this)',
                          'data'=>$model->id]);  
                    },
                    'response'=>function($url,$model,$key){
                            return \yii\bootstrap\Html::a("回复",'#',[
                          'data-toggle'=>'modal' ,'data-target'=>'#responseModal'.$model->id,
                          'onclick'=>'response(this)',
                          'data'=>$model->id,
                          'key'=>$model->unique_key ]); 
                    }
                ]
            ],
        ],
    ]); ?>
</div>
<div class="modal fade appmotai" >
    <div class="modal-dialog">
        <?php $form = ActiveForm::begin([
            'id'=>'Approve-Comment',
            'options' => ['class' => 'modal-content form-horizontal'],
            'fieldConfig' => [
                    'template' => ' <label class="col-sm-4 control-label" for="pwd">{label}:</label>
                                      <div class="col-sm-6">{input}<span class="help-block" style="color:#a94442;"><span></div> ',
                   'inputOptions' => ['class' => 'form-control'],
                 ],
            ]); ?>
            <div class="modal-header">
                审核操作
            </div>
            <div class="modal-body">
                <input id="add_stu_id" name="ApproveComment[id]" value="" type="hidden">             
                <?= $form->field($model, 'flag',['labelOptions' => ['class' => 't-r-pd5']])->dropDownList(['1'=>'已审核', '0'=>'待审核'])->label('状态'); ?>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-8">
                       <?= Html::submitButton('审核', ['class' => 'form-control btn-success']) ?>
                    </div>
                </div>
            </div>    
        <?php ActiveForm::end(); ?>                  
    </div>
</div>
<div class="modal fade response" >
    <div class="modal-dialog">
        <?php $form = ActiveForm::begin([
            'id'=>'Response-Comment',
            'options' => ['class' => 'modal-content form-horizontal'],
            'fieldConfig' => [
                    'template' => ' <label class="col-sm-2 control-label" for="pwd">{label}:</label>
                                      <div class="col-sm-8">{input}<span class="help-block" style="color:#a94442;"><span></div> ',
                   'inputOptions' => ['class' => 'form-control'],
                 ],
            ]); ?>
            <div class="modal-header">
               回复用户评论
            </div>
            <div class="modal-body">
                <input id="add_unique_key" name="ResponseComment[unique_key]" value="" type="hidden">
                <input id="add_rep_id" name="ResponseComment[rep_id]" value="" type="hidden">
                <?= $form->field($modelResponse, 'content',['labelOptions' => ['class' => 't-r-pd5']])->textArea(['rows' => '6'])->label('内容'); ?>              
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-8">
                       <?= Html::submitButton('确定', ['class' => 'form-control btn-success']) ?>
                    </div>
                </div>
            </div>    
        <?php ActiveForm::end(); ?>                  
    </div>
</div>
<script type="text/javascript">
    function hiddenId(obj){
        var id=$(obj).attr('data');
        var v='approveModal'+id;
        $(".appmotai").attr('id',v);
        $("#add_stu_id").val(id);      
    }
    function response(obj){
        var id=$(obj).attr('data');
        var key=$(obj).attr('key');
        var v='responseModal'+id;
        $(".response").attr('id',v);
        $("#add_rep_id").val(id);
        $("#add_unique_key").val(key);
    }
</script>