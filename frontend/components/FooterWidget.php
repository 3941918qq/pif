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

class FooterWidget extends Widget{
    public $footer;
    //获取菜单数据
    public function init(){
        parent::init();
//        $this->footer=2;
    }
    //run
    public function run(){
          $str='<footer class="navbar navbar-fixed-bottom navbar-default " role="navigation">
                <div class="container footerul" >
                    <ul class="nav nav-pills">
                     <div class=" col-xs-3 col-sm-3 col-md-3 col-lg-3 ">
                        <li role="presentation" class="active text-center ">
                          <a href="'. Url::toRoute(['course/view']).'">
                               <div class="row  footer-cor ">
                                  <span class="glyphicon glyphicon-book keye"></span><br> 
                                  <span class="val">课程</span>
                               </div>

                          </a>
                        </li>
                      </div>
                      <div class=" col-xs-3 col-sm-3 col-md-3 col-lg-3 ">
                        <li role="presentation" class="active text-center ">
                          <a href="'. Url::toRoute(['home/view']).'">
                               <div class="row  footer-cor ">
                                  <span class="glyphicon glyphicon-folder-open keye"></span><br> 
                                  <span class="val">产品</span>
                               </div>

                          </a>
                        </li>
                      </div>
                      <div class=" col-xs-3 col-sm-3 col-md-3 col-lg-3">
                          <li role="presentation" class="text-center"><a href="'. Url::toRoute(['success-example/view']).'">
                               <div class="row footer-cor">
                                  <span class="glyphicon glyphicon-th-large keye"></span><br> 
                                  <span class="val">案例</span>
                               </div>
                              </a></li>
                      </div>
                      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <li role="presentation" class="text-center"><a href="'. Url::toRoute(['mine/index']).'">
                               <div class="row footer-cor">
                                  <span class="glyphicon glyphicon-user keye"></span><br>
                                  <span class="val">我的</span>
                               </div>
                            </a></li>
                      </div>
                    </ul>
                </div>
              </footer>';
        return $str;
    }
}




