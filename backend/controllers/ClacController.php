<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use backend\controllers\BaseController;
use common\models\DataManage;
use common\models\User;
use common\models\SuccessExample;
use common\models\Comment;
use common\models\GiveLike;
use yii\helpers\ArrayHelper;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ClacController extends BaseController{
    public function actionIndex(){
        //成功案例所有产品以及各产品的浏览量、点赞量、评论量       
        //①各产品被收藏点赞数量
        $successExampleModel=SuccessExample::find()->select('success_example.*,count(c.unique_key)')
                ->join('LEFT JOIN','comment c','c.unique_key=success_example.unique_key')
                ->groupBy('success_example.unique_key')
                ->orderBy('success_example.id ASC')
                ->asArray()->all();
        if($successExampleModel){
            $data['successExampleId']=ArrayHelper::getColumn($successExampleModel, 'id');
            $data['successExamplePageView']=ArrayHelper::getColumn($successExampleModel, 'page_view');
            $data['successExampleGivelikeTotal']=ArrayHelper::getColumn($successExampleModel, 'givelike_total');
            $data['successExampleCommentCount']=ArrayHelper::getColumn($successExampleModel, 'count(c.unique_key)');
            foreach($successExampleModel as $key=>$value){
                $successExampleModel[$key]['allTotal']=$value['page_view']+$value['givelike_total']+$value['count(c.unique_key)'];
            }
            $data['successExampleAllTotal']=ArrayHelper::getColumn($successExampleModel, 'allTotal');
        }else $data=[];
        
        //产品中心所有产品以及各产品的浏览量、点赞量、评论量       
        //①各产品被收藏点赞数量
        $dataManageModel=DataManage::find()->select('data_manage.*,count(c.unique_key)')
                ->join('LEFT JOIN','comment c','c.unique_key=data_manage.unique_key')
                ->groupBy('data_manage.unique_key')
                ->orderBy('data_manage.id ASC')
                ->asArray()->all();
         
        if($dataManageModel){
            $data['dataManageId']=ArrayHelper::getColumn($dataManageModel, 'id');
            $data['dataManagePageView']=ArrayHelper::getColumn($dataManageModel, 'page_view');
            $data['dataManageGivelikeTotal']=ArrayHelper::getColumn($dataManageModel, 'givelike_total');
            $data['dataManageCommentCount']=ArrayHelper::getColumn($dataManageModel, 'count(c.unique_key)');
            foreach($dataManageModel as $key=>$value){
                $dataManageModel[$key]['allTotal']=$value['page_view']+$value['givelike_total']+$value['count(c.unique_key)'];
            }
            $data['dataManageAllTotal']=ArrayHelper::getColumn($dataManageModel, 'allTotal');
        }
//        var_dump($data );die;
//        var_dump( $successExampleModel);die;
        return $this->render('index',[
            'data'=>$data,
        ]);
    }
}
