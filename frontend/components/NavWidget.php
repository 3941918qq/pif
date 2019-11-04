<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace frontend\components;

use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\CodeList;

class NavWidget extends Widget{
    public $nav;
    //获取菜单数据
    public function init(){
        parent::init();
        $list=CodeList::find()->asArray()->indexBy("id")->orderBy(['code'=>SORT_DESC,'num'=>SORT_ASC])->all();
        $data=['id'=>'0','type'=>'0','code'=>'0','name'=>'全部'];
        array_unshift($list,$data);
        $controllerId=yii::$app->controller->id;
        $data['nav']=$list;
        $data['controllerId']=$controllerId;
//        var_dump($controllerId);die;
        $this->nav=$data;
    }
    //run
    public function run(){
        $str='<nav class="topmenu navbar navbar-fixed-top container">
                    <div class="swiper-container div_logo">
                        <img class="sbrand" src="/img/LOGO.png" alt="">
                    </div>   
                    <div class="swiper-container" style="width:74%;margin:0;padding:0;" >
                        <div class="swiper-wrapper " style="" >';
                        foreach($this->nav['nav'] as $k=>$v){
                         $str.= '<a  class="swiper-slide sbrand" href="';
                            if($this->nav['controllerId']=="home"){
                                $str.='/home/view';
                            }else if($this->nav['controllerId']=="success-example"){
                                $str.='/success-example/view';
                            }else if($this->nav['controllerId']=="mine"){
                                 $str.='/mine/view';
                            }
                         $str.='?code='.$v['id'].'&type='.$v['code'].'&key='.$k.'" ><span value='.$k.' class="nav_img" id='.$v['id'].' type='.$v['code'].'>'.$v['name'].'</span></a>';
                        }
                       $str.=' </div>  
                        
                    </div>
                    <span  onclick="link(this)" class="glyphicon glyphicon-search nav-search" aria-hidden="true"></span>
                    
              </nav>';
        return $str;
    }
}

// <div class="input-group" style="width:99%;margin:2px auto;btn-audio" onclick="link(this)">
//                        <input type="text" class="form-control" placeholder="请输入标题..." aria-describedby="basic-addon2" style="background-color:transparent;" disabled>
//                        
//                        <span class="input-group-addon " id="basic-addon2" ><span class="glyphicon glyphicon-search"></span></span>
//                    </div> 


