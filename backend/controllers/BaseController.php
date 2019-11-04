<?php
namespace backend\controllers;

use Yii;
use common\models\DataManage;
use common\models\SuccessExample;
use common\models\DataManageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BaseController extends Controller{
    
    public function init(){
        parent::init();
    }
    
    
    public function beforeAction($action){
        // $this->viewPath = '@backend/views/login';
        if (Yii::$app->user->isGuest){
            return $this->redirect("/site/login")->send();
        }else return true;

    }
     public function actions() {
        return [
            'upload' => [
                'class' => \xj\ueditor\actions\Upload::className(),
                'uploadBasePath' => '@webroot/uploads/img', //file system path
                'uploadBaseUrl' =>  '@web/uploads/img', //web path
                'csrf' => true, //csrf校验
                'configPatch' => [
                    'imageMaxSize' => 1920 * 1080, //图片
                    'scrawlMaxSize' => 1920 * 1080, //涂鸦
                    'catcherMaxSize' => 1920 * 1080, //远程
                    'videoMaxSize' => 1920 * 1080, //视频
                    'fileMaxSize' => 1920 * 1080, //文件
                    'imageManagerListPath' => '//', //图片列表
                    'fileManagerListPath' => '//', //文件列表
                ],
                // OR Closure
                'pathFormat' => [
                    'imagePathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'scrawlPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'snapscreenPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'snapscreenPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'catcherPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'videoPathFormat' => 'video/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'filePathFormat' => 'file/{yyyy}{mm}{dd}/{time}{rand:6}',
                ],

                // For Closure
                'pathFormat' => [
                    'imagePathFormat' => [$this, 'format'],
                    'scrawlPathFormat' => [$this, 'format'],
                    'snapscreenPathFormat' => [$this, 'format'],
                    'snapscreenPathFormat' => [$this, 'format'],
                    'catcherPathFormat' => [$this, 'format'],
                    'videoPathFormat' => [$this, 'format'],
                    'filePathFormat' => [$this, 'format'],
                ],

                'beforeUpload' => function($action) {
//                  throw new \yii\base\Exception('error message before'); //break

                },
                'afterUpload' => function($action) {
                },
            ],
        ];
    }

    // for Closure Format
    public function format(\xj\ueditor\actions\Uploader $action) {
        $fileext = $action->fileType;
        $filehash = sha1(uniqid() . time());
        $p1 = substr($filehash, 0, 2);
        $p2 = substr($filehash, 2, 2);
        $a="{$p1}/{$p2}/{$filehash}{$fileext}";
        return "{$p1}/{$p2}/{$filehash}{$fileext}";
    }
}