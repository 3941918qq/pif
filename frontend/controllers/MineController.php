<?php
namespace frontend\controllers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use frontend\controllers\BaseController;
use common\models\User;
use frontend\models\RegistForm;
use frontend\models\LoginForm;
use frontend\models\GetMineInfoForm;
use frontend\models\ChangeTelForm;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class MineController extends BaseController{
    public $layout="home-header";
    //我的首页
    public function actionIndex(){
        $uid=yii::$app->view->params['uid'];
        $model =User::findOne($uid);
        $level=$this->getUserLevel($model);
        return $this->render('index',[
            'model'=>$model,
            'level'=>$level
        ]);
    }
   
    //我的评论、点赞、分享、浏览历史
    public function actionMylike(){
        $uid=yii::$app->view->params['uid'];
        $this->authentication($uid);
        $model=new GetMineInfoForm;        
        $type=Yii::$app->request->get('type');
        $arrHistoryUnique=$this->historyView();
        $data=$model->getAll($uid,$arrHistoryUnique);
        return $this->render('mylike',[
            'comment'=>$data['comment'],
            'ComPagination'=>$data['ComPagination'],
            'givelike'=>$data['givelike'],
            'GivePagination'=>$data['GivePagination'],
            'history'=>$data['history'],
            'type'=>$type,
        ]);
    }
    //我的资料
    public function actionMyinfo(){
        $uid=yii::$app->view->params['uid'];  
        $this->authentication($uid);
        $model = User::findOne($uid);
        return $this->render('myinfo',[
            'model'=>$model,
        ]);
    }
    //完善资料
    public function actionCompleteinfo(){
        $model=new RegistForm;
        $uid=yii::$app->view->params['uid'];
        $this->authentication($uid);
        if ($model->load(Yii::$app->request->post()) ) {
            
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');  
            if($model->imageFile){
                if ($model->upload() && $model->save($uid,$type="change")) {
                    return $this->redirect(['/mine/index']);
                }
            }else{
                if ($model->save($uid,$type="change")) {
                    return $this->redirect(['/mine/index']);
                }
            }
                      
        }  
        $modelUser =User::findOne($uid);
        return $this->render('completeinfo', [
            'model' => $model,
            'modelUser'=>$modelUser
        ]);
    }
    //更换号码
    public function actionChangetel(){
        $model=new LoginForm;
        $uid=yii::$app->view->params['uid'];
        $this->authentication($uid);
        if ($model->load(Yii::$app->request->post()) && $model->changetel()) {
             return $this->redirect(['/mine/newtel']);
        }
        return $this->render('changetel', [
            'model'=>$model,
        ]);
    }
    //新号码页面
    public function actionNewtel(){
        $model=new ChangeTelForm;
        $session = Yii::$app->session; 
        $uid=yii::$app->view->params['uid'];
        $this->authentication($uid);
        if(!isset($session['code']) || $session['code']['expire_time'] < time()){
              return $this->redirect(['/mine/index']);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save($uid)) {
             return $this->redirect(['/mine/index']);
        }
        return $this->render('newtel', [
            'model'=>$model,
        ]);
    }
    public function actionRank(){
        //获取当前用户身份
        $score=yii::$app->request->get('score');
        if($score<0 ||is_null($score)) throw new NotFoundHttpException('您访问的页面不存在.');
        return $this->render('rank',['score'=>$score]);
    }
    //邀请好友
    public function actionShare(){
        $uid=yii::$app->view->params['uid'];
        $this->authentication($uid);
        $model=new GetMineInfoForm; 
        $data=$model->qrcode($uid);
        return $this->render('share',['data'=>$data]);
    }
    //联系我们
    public function actionAboutus(){
        return $this->render('aboutus');
    }
    
    public function actionIssign(){
       $time = time();
       $uid=yii::$app->view->params['uid'];
       $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
       $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
       $model=User::find()->where(['and', "id=$uid", ['between', 'sign_time', $beginToday,$endToday ]])->one();
       if($model){
           return $this->FormatJson(1);
       }else return $this->FormatJson(0);
    }
    //执行签到
    public function actionSigndesk(){
        $uid=yii::$app->view->params['uid'];
        $model =User::findOne($uid);
        $model->updateCounters(['score'=>5]);
        $model->sign_time=time();
        if($model->save(false)){
            return $this->FormatJson('success');
        }
    }
}
