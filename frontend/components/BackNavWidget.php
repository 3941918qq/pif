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

class BackNavWidget extends Widget{
    public $backNav;
    //获取菜单数据
    public function init(){
        parent::init();
    }
    //run
    public function run(){
        $str='<nav class="topmenu  navbar navbar-fixed-top navbar-inverse">
                    <div class="swiper-container div_logo">
                        <span class="sbrand glyphicon glyphicon-chevron-left" onclick="returnStep()"></span>
                    </div>           
              </nav>';
        return $str;
    }
}




