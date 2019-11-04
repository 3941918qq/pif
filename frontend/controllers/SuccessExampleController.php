<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\controllers\BaseController;
use common\models\SuccessExample;
use frontend\models\SuccessExampleViewForm;
/**
 * SuccessExample controller
 */
class SuccessExampleController extends BaseController
{
    public $layout="home-header";
    
    public $enableCsrfValidation = false;

    protected $userHistoryPrefix="history-success-";
    
    protected $hotHistoryPrefix="hot-success";
    
    protected $modelName= "SuccessExampleViewForm";
    //浏览量加1
    public function actionAddPageview(){
        if(yii::$app->request->isAjax){
            $post=yii::$app->request->post();
            $datamanage = SuccessExample::find()->where(['unique_key' => $post['uniquekey']])->one();
            $result=$datamanage->updateCounters(['page_view'=>1]);
            return $this->FormatJson($result);
        }
    }
    //上拉加载数据
    public function actionRecords(){
        return  $this->records($course=null);       
    }    
         
}



