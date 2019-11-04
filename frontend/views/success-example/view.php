<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\components\FooterWidget;
use frontend\components\NavWidget;
use yii\widgets\LinkPager;
$this->title="成功案例";
?>
<?= NavWidget::widget()?>
<!-- 内容 -->
<style>
h3{font-size:2rem;}
</style>
  <div id="main">
 </div>
  <input type="hidden" id="type" name="type" value="<?= (isset($get['type'])) ? $get['type'] :null?>" />
  <input type="hidden" id="code"  name="code" value="<?= (isset($get['code'])) ? $get['code'] :null?>" />
  <input type="hidden" id="key" name="key" value="<?= (isset($get['key'])) ? $get['key'] :null?>" />
  <input type="hidden" id="search" name="search" value="<?= (isset($get['search'])) ? $get['search'] :null?>" />
<!-- footer -->
 <?= FooterWidget::widget()?>
<script>   
    // 处理手机软键盘弹出后，把底部logo顶上去的问题
    var height = $(window).height();
    $(window).on('resize', function () {
        if ($(window).height() < height) {
            $(".navbar-fixed-bottom").hide();
        } else {
            $(".navbar-fixed-bottom").show()
        }
    });   
    function link(jump){
        window.location.href="/success-example/search";    
    }
    //初始化， 第一次加载
    $(document).ready(function() {
        LoadingDataFn();
        $(".data-list:even").addClass('col-md-offset-2');
    });
    var LoadingDataFn=function(){
        var type=$("#type").val();
        var code=$("#code").val();
        var key=$("#key").val();
        var search=$("#search").val();
        var url='/success-example/records?page='+page;
        if(type!=''){ url+='&type='+type;}
        if(code!=''){ url+='&code='+code;}
        if(key!=''){url+='&key='+key;}
        if(search!=''){ url+='&search='+search;}
        $.ajax({
            type:'get',
            url:url,
            async:false,
            dataType:'json',
            success:function(ret){               
                $.each(ret.message,function(i,info){
                       var div=" <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 data-list' style='padding:0;'>\n\
                                 <a href='/success-example/data-detail?dataid="+info.id+"&unique="+info.unique_key+"'>\n\
                                    <h3 style='margin:2px auto;padding:5px;font-size:1.7rem;padding-top:20px;'>"+info.title+"</h3>\n\
                                   <div class='thumbnail'>\n\
                                    <img src='"+info.img_url+"' alt='...' class='success-example-img'>\n\
                                    <p class='degist'> \n\
                                       <span class='glyphicon glyphicon-eye-open' aria-hidden='true'>"+info.page_view+"</span>\n\
                                       <span class='glyphicon glyphicon-heart' aria-hidden='true'>"+info.givelike_total+"</span>\n\
                                       <span class='glyphicon glyphicon-edit' aria-hidden='true'>"+info.comment_total+"</span>\n\
                                    </p></div></a> </div> ";
                        $("#main").append(div); 
                  })
             if(ret.message.length<6){
                 var p="<div style='clear:both;'></div><p class='text-center' style='padding-top:15px;font-size:1.6rem;color:#bbb;'>...更多内容敬请关注...</p>";
                 $("#main").append(p);
                 isLoading=false;
             }else{
                 isLoading=true;
             }
            },
        });
        
    }
</script>