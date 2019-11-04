<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\LoginForm;
use frontend\models\RegistForm;
use common\models\User;
use common\models\College; 
use common\models\DataManage;
/**
 * Site controller
 */
class IndexController extends Controller{
    public $layout="home-header";
    
    public $enableCsrfValidation = false;

    public function actionLogin(){
        if(Yii::$app->request->get('unique')!=null){
           $recommendUserId=Yii::$app->request->get('unique');
        }else $recommendUserId=null;
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post() )) {
            $result = $model->login($recommendUserId);
            if ($result['status']=="needComplete") {
                if(isset($result['recommend'])){
                    return  $this->redirect(['/index/regist','id'=>$result['uid'],'recommend'=>$result['recommend']]);
                }else return  $this->redirect(['/index/regist','id'=>$result['uid']]);                
            }else if($result['status']=="alreadyComplete"){
                // $session = Yii::$app->session;
                // $session['userinfo']=[
                //      'uid' =>$result['uid'],  //数据
                //      'expire_time' => time() + 3600*24*30, 
                // ];              
                return  $this->redirect(['/home/view','id'=>$result['uid']]);
            }        
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    
    public function actionRegist($id=null){
        $session = Yii::$app->session;
        if(!isset($session['code']) || $session['code']['expire_time'] < time() || !isset($id)){
                return  $this->redirect(['/index/login']);
        }
        if(Yii::$app->request->get('recommend')!=null){
           $recommendUserId=Yii::$app->request->get('recommend');
        }else $recommendUserId=null;
        $model = new RegistForm();       
        if ($model->load(Yii::$app->request->post()) && $model->save($id,null,$recommendUserId)) {
            // $session = Yii::$app->session;
            // $session['userinfo']=[
            //      'uid' => $id,  //数据
            //      'expire_time' => time() + 3600*24*30, 
            // ];
            return $this->redirect(['/home/view', 'id' => $id]);
        }
        return $this->render('regist', [
            'model' => $model,
        ]);
    }
     //发送手机短信
    public function actionSendMsg(){
        if(Yii::$app->request->isAjax){
            $tel=Yii::$app->request->post('tel');
            $rand=  mt_rand(100000, 999999);
            $session = Yii::$app->session;
            if (!$session->isActive){
                $session->open();               
            }           
            $data = [
              'num' => $rand,  //数据
              'expire_time' => time() + 600, 
            ];
            $session['code'] = $data;    
            $response = Yii::$app->aliyun->sendSms(
                "捷安高科", // 短信签名
                "SMS_151577370", // 短信模板编号
                $tel, // 短信接收者
                Array(  // 短信模板中字段的值
                    "code"=>$rand,
                )
            );
            $response=json_decode($response);
            return $response->code;
        }return false;
    }
    //检索单位
    public function actionSearchCompany(){
        if(yii::$app->request->isAjax){
            $value=yii::$app->request->post('val');
            if($value){
                $college=College::find()->where(['like','name',$value])->asArray()->all();
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [ 'data' =>$college]; 
            }else{
                return [ 'data' =>[]];
            }
                     
        }else throw new NotFoundHttpException("对不起，无法进行该操作！");
    }
    
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect("/index/login")->send();
    }
}

