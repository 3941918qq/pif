<?php
use yii\helpers\Html;
use yii\widgets\ListView;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = '首页';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .biaoti{
        color:#337ab7;
    }
</style>
<h2>新注册</h2>
<div class="table-responsive ">
  <table class="table table-bordered table-striped">
      <thead>
            <tr class="biaoti">
                <th>序号</th>
                <th>姓名</th>
                <th>Email</th>
                <th>电话</th>
                <th>地区</th>
                <th>单位</th>
                <th>单位地址</th>
                <th>注册时间</th>
            </tr>
      </thead>
      <tbody>
          <?php foreach($modelUser as $k=>$v) {?>
            <tr>
                <td><?= $k+1 ?></td>
                <td><?= $v['name'] ?></td>
                <td><?= $v['email'] ?></td>
                <td><?= $v['username'] ?></td>
                <td><?= $v['area'] ?></td>
                <td><?= $v['company'] ?></td>
                <td><?= $v['address'] ?></td>
                <td><?= date('Y-m-d H:i:s',$v['created_at']) ;?></td>
           </tr>
          <?php }?>
     </tbody>
  </table>
</div>

<h2>新评论</h2>
<div class="table-responsive ">
  <table class="table table-bordered  table-striped">
      <thead>
            <tr class="biaoti">
                <th style="width:50px;">序号</th>
                <th style="width:80px;">用户</th>
                <th>电话</th>
                <th>产品名称</th> 
<!--                <th>产品识别码</th>                -->
                <th>内容</th>
                <th>评论角色</th>
                <th>是否审核</th>
                <th>评论时间</th>
                
            </tr>
      </thead>
      <tbody>
          <?php foreach($modelComment as $k=>$v) {?>
            <tr>
                <td style="width:50px;"><?= $k+1 ?></td>
                <td style="width:80px;"><?= $v['name'] ?></td>
                <td><?= $v['username'] ?></td>
                <td><?= (strlen($v['title']) > 18) ? mb_substr($v['title'],0,18,'utf-8').'...' :$v['title']; ?></td>
<!--                <td><?= $v['unique_key'] ?></td>-->
                <td><?= (strlen($v['content']) > 21) ? mb_substr($v['content'],0,21,'utf-8').'...' :$v['content']; ?></td>
                <td><?= ($v['type']=='com') ? '用户' : '管理员'; ?></td>
                <td><?= ($v['flag']==1) ? '是' : '否'; ?></td>
                <td><?= $v['ctime'];?></td>
           </tr>
          <?php }?>
     </tbody>
  </table>
</div>

<h2>用户概况</h2>
<div class="table-responsive ">
  <table class="table table-bordered table-striped">
      <thead>
            <tr class="biaoti">
                <th>总用户数</th>
                <th>普通用户数</th>
<!--                 <th>VIP用户数</th> -->
                <th>周新增用户数</th>                
                <th>月新增用户数</th>
                <th>周活跃用户数</th>
                <th>月活跃用户数</th>            
            </tr>
      </thead>
      <tbody>
            <tr>
                <td><?= $user['count'] ?></td>
                <td><?= $user['notVipCount'] ?></td>
     <!--            <td><?= $user['isvipCount'] ?></td> -->
                <td><?= $user['lastWeekAddUser'] ?></td>
                <td><?= $user['lastMonthAddUser'] ?></td>
                <td><?= $user['lastWeekLoginUser'] ?></td>
                <td><?= $user['lastMonthLoginUser'] ?></td>
           </tr>
     </tbody>
  </table>
</div>

<h2>产品概况</h2>
<div class="table-responsive ">
  <table class="table table-bordered table-striped">
      <thead>
            <tr class="biaoti">
                <th>总浏览量</th>
                <th>总点赞量</th>
                <th>总评论量</th>           
            </tr>
      </thead>
      <tbody>
            <tr>
                <td><?= $product['pageViewCount'] ?></td>
                <td><?= $product['giveLikeCount'] ?></td>
                <td><?= $product['commentCount'] ?></td>
           </tr>
     </tbody>
  </table>
</div>