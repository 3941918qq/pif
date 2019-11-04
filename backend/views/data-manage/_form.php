<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\CodeList;
use \xj\ueditor\Ueditor;
/* @var $this yii\web\View */
/* @var $model common\models\DataManage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-manage-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!--     $form->field($model, 'url')->textInput(['maxlength' => true])-->
    
    <?= $form->field($model, 'videoFile')->fileInput(['onchange'=>'checkextension(this.value)'])->label('视频文档上传') ?>

    <?= $form->field($model, 'content')->widget(Ueditor::className(), [
        'style' => 'width:100%;height:200px',
        'renderTag' => true,
        'readyEvent' => 'console.log("example2 ready")',
        'jsOptions' => [
            'serverUrl' => yii\helpers\Url::to(['upload']),
            'autoHeightEnable' => true,
            'autoFloatEnable' => true
        ],
    ])?>
<!--  $form->field($model, 'content')->textarea(['rows' => 6])-->

    <?= $form->field($model, 'type')->dropDownList(['video' => '视频', 'text' => '文档',  ]) ?>

    <?= $form->field($model, 'code_id')->dropDownList(
            CodeList::find()
            ->select(['name'])
            ->where(['code'=>2])
            ->indexBy('id')
            ->column()
    )->label('业务类别') ?>
    <?= $form->field($model, 'car_id')->dropDownList(
            CodeList::find()
            ->select(['name'])
            ->where(['code'=>1])
            ->indexBy('id')
            ->column()
    )->label('车辆类别') ?>

<!--    $form->field($model, 'isvip_view')->dropDownList([ 1 => '可见', 0 => '不可见', ], ['prompt' => ''] )-->
           
   <?= $form->field($model, 'is_top')->dropDownList([ 0 => '不展示', 1 => '展示', ])?>
   <?= $form->field($model, 'view_level')->dropDownList(yii::$app->params['view_level'])?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src="/js/jquery.js"></script>
<script type="text/javascript">
function checkextension(filename){
        var arr = ['mp4','ogg','jpg','png','gif'];
        var index = filename.lastIndexOf(".");
        var ext = filename.substr(index+1);
        //循环比较
        if( $.inArray(ext, arr)<0){
                alert('视频文件仅支持.mp4(AVC编码),.ogg格式！\n图片文件支持jpg、png、gif格式！');
                $('#file').val("");
                return false;
        }
 }
</script>
