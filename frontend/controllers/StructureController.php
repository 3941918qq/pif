<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\controllers\BaseController;

class StructureController extends BaseController
{
    public $layout="home-header";

    public function actionIndex(){
        // $uid=yii::$app->view->params['uid'];
        // $model =User::findOne($uid);
        return $this->render('index',[
            // 'model'=>$model
        ]);
    }
}