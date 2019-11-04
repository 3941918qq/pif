<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use frontend\components\FooterWidget;
//AppAsset::register($this);
// $this->title="首页";
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="/css/swiper.min.css" rel="stylesheet">
    <link  href="/css/home.css" rel="stylesheet">
    <link href="/css/common.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/img/jagk.ico" rel="icon">
    <script src="/js/jquery-1.12.4.min.js"></script>
    <script  src="/js/bootstrap.min.js"></script>
    <script  src="/js/swiper.jquery.min.js"></script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<style>
    body {-webkit-overflow-scrolling: touch;}
</style>
<body>
<?php $this->beginBody() ?>
    <input type="hidden" name="controller" id="controller" value="<?= Yii::$app->controller->id?>">
        <?= $content ?>
<div class="back-top" onclick="goTop(this)">
    <span class="glyphicon glyphicon-chevron-up  up-chevron" aria-hidden="true"></span>
</div>
<script type="text/javascript">
   
    $(document).ready(function(){
        $(".back-top").hide();
        //顶部导航滚动效果
         var swiper = new Swiper('.swiper-container', {
            spaceBetween: -1,
            slidesPerView:'auto',
            freeMode: true
        }); 
        //底部导航样式toggle
        var controller= $("#controller").val();
        if(controller=="course"){
            $(".footer-cor:eq(0)").addClass('oncheck');
        }else if(controller=="home"){
            $(".footer-cor:eq(1)").addClass('oncheck');
        }else if(controller=="success-example"){
            $(".footer-cor:eq(2)").addClass('oncheck');
        }else if(controller=="mine"){
            $(".footer-cor:eq(3)").addClass('oncheck');
        }
        //给点击的顶部按钮添加样式
        var str=location.href; //取得整个地址栏
        var arr=str.split("&");
        console.log(arr[2]);
        // var num=str.lastIndexOf("&")
        // str=str.substr(num+1); //取得所有参数   stringvar.substr(start [, length ]
        // var arr=str.split("="); //各个参数放到数组里

        // if(arr[1]==0 && arr[0]=="key"){
        if(arr[2]=="key=0"){
            $(".nav_img:eq(0)").addClass("onthis");
        }else if(arr[2]=="key=1"){
            $(".nav_img:eq(1)").addClass("onthis");
        }else if(arr[2]=="key=2"){
            $(".nav_img:eq(2)").addClass("onthis");
        }else if(arr[2]=="key=3"){
            $(".nav_img:eq(3)").addClass("onthis");
        }else if(arr[2]=="key=4"){
            $(".nav_img:eq(4)").addClass("onthis");
        }else if(arr[2]=="key=5"){
            $(".nav_img:eq(5)").addClass("onthis");
        }else  $(".nav_img:eq(0)").addClass("onthis");       
    })
    //返回顶部
    function goTop(ths){
        $("#main")[0].scrollTop=0;
    }

    //返回
    function returnStep(){
        window.history.go(-1);
    }
    
    //退出登录
    function logout(){
        if(window.confirm("您确定要退出当前账号吗？")){
            window.location.href="/index/logout";
        }
    }
    //鉴权
    function checkAuth(){
        var auth=$("#auth").val();
         if(auth>0){
            window.location.href="/index/login";
            return false;
         }
    }
    
  /**以下是滚动加载内容**/  
    var page=1;
    var isLoading=false;          
    //滚动加载方法1
    $('#main').scroll(function() {
        if($(this)[0].scrollTop>0){
            $(".back-top").show();
        }else{
            $(".back-top").hide();
        }
        //当时滚动条离底部50px时开始加载下一页的内容
        if (($(this)[0].scrollTop + $(this).height()+50) >= $(this)[0].scrollHeight) {             
            //这里用 [ isLoading ] 来控制是否加载 
            if (isLoading) {
                console.log(isLoading);
                isLoading = false;
                page++;
                LoadingDataFn();  //调用执行上面的加载方法
                $(".data-list:even").addClass('col-md-offset-2');
            }
        }
    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


