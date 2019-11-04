<?php
use frontend\components\BackNavWidget;
use yii\helpers\Html;
$this->title="我的资料";
?>
<style>
    .person{font-size:1.4rem;margin-top:15px;border:none;line-height: 32px;}
    .person-info{float:right;margin-top:25px;}
</style>
<!-- 内容 -->
<div class="container">
<div class="row">
 
    <div class="thumbnail person">
       <img src="<?= (Html::encode($model->img_url) )? Html::encode($model->img_url):'/img/garf.jpg'?>" alt="140*140" class="img-circle header_img" style="width:150px;height:140px;">  

       <!-- <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 person-info">
             <ul  class="list-unstyled">
              <li><?= Html::encode($model->name) ?></li>
              <li><?= (Html::encode($model->sex)=='1' ) ? "女" : "男"?></li>
              <li><?= Html::encode($model->birthday) ?></li>
              <li><?= (Html::encode($model->is_vip)==0 ) ? "普通用户" :"vip用户"?></li>
            </ul>
       </div> -->
       <!-- <div class="clearfix"></div>
        <div class=""  style="width:50%;margin:0 auto;">
            <ol class="list-unstyled text-left">
              <li>手机号码：<?= Html::encode($model->username) ?></li>
              <li>邮地地址：<?= (Html::encode($model->email)) ? Html::encode($model->email) : "(暂未填写)" ;?></li>
              <li>现居住地：<?= (Html::encode($model->area)) ? Html::encode($model->area) : "(暂未填写)" ;?></li>
              <li>所属单位：<?= (Html::encode($model->company)) ? Html::encode($model->company) : "(暂未填写)" ;?> </li>
              <li>单位地址：<?= (Html::encode($model->address)) ? Html::encode($model->address) : "(暂未填写)" ; ?></li>
            </ol>
       </div>
        <div class="clearfix"></div> -->
    </div>


 
</div>
    <table class="table ">
        <tr><td width="100px">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</td><td><?= Html::encode($model->name) ?></td></tr>
        <tr><td>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</td><td><?= (Html::encode($model->sex)=='1' ) ? "女" : "男"?></td></tr>
        <tr><td>出生日期：</td><td><?= Html::encode($model->birthday) ?></td></tr>
        <tr><td>用户类别：</td><td><?= (Html::encode($model->is_vip)==0 ) ? "普通用户" :"vip用户"?></td></tr>
        <tr><td>手机号码：</td><td><?= Html::encode($model->username) ?></td></tr>
        <tr><td>邮地地址：</td><td><?= (Html::encode($model->email)) ? Html::encode($model->email) : "(暂未填写)" ;?></td></tr>
        <tr><td>现居住地：</td><td><?= (Html::encode($model->area)) ? Html::encode($model->area) : "(暂未填写)" ;?></td></tr>
        <tr><td>所属单位：</td><td><?= (Html::encode($model->company)) ? Html::encode($model->company) : "(暂未填写)" ;?></td></tr>
        <tr style="border-bottom:1px solid #ddd;"><td>单位地址：</td><td><?= (Html::encode($model->address)) ? Html::encode($model->address) : "(暂未填写)" ; ?></td></tr>
    </table>
</div>


