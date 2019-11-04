<?php
namespace frontend\controllers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\DataManage;
use common\models\SuccessExample;
use common\models\User;
use frontend\models\DataManageViewForm;
use frontend\models\SuccessExampleViewForm;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class BaseController extends Controller{
    protected $historyViewPrefix="history-view-";
        
    public function init(){
        parent::init();     
    }

    public function beforeAction($action){
        if (Yii::$app->user->isGuest){
            \yii::$app->view->params['uid']=0;
            return true;
//            return $this->redirect("/index/login")->send();
        }else{
            \yii::$app->view->params['uid']=yii::$app->user->id;
            return true;
        }

    }
     //获取当前用户等级
    protected function getUserLevel($obj){
        if(!$obj) return 0;
        $score=$obj->score;
        if($score<100){
            return 1;
        }elseif($score>=100 && $score<500){
            return 2;
        }elseif($score>=500){
            return 3;
        }
    }
    //鉴权uid不存在或者为0的都是游客，跳转登陆页面
    public function authentication($uid){  

        if(!isset($uid) || $uid==0){
            $url=yii::$app->params['frontend.url'].'/index/login';
            header("location:".$url);
            exit;
        }
    }
    
    public static function factory($transport)
    {
        
        switch ($transport) {
            case 'SuccessExampleViewForm':
                return new SuccessExampleViewForm();
                break;

            case 'DataManageViewForm':
                return new DataManageViewForm();
                break;
        }
    }   
    //用户浏览历史
    public function historyView($value=null){
        $uid=\yii::$app->view->params['uid'];
        $redis = Yii::$app->redis;
        $historyViewKey=$this->historyViewPrefix.$uid;        
        if(isset($value)){
            $redis->zadd($historyViewKey,time(),$value);
        }else{
            return $arrUniqueKey=$redis->zrevrange($historyViewKey,0,20);
        }
    }

    //历史搜索和热门搜索
    public function getHistorySearch($keyhis,$keyhothis,$value=null){
        $redis = Yii::$app->redis;
        $uid=\yii::$app->view->params['uid'];
        if($value && $uid!=0){
            $redis->lpush($keyhis,$value); 
            $score=$redis->zscore($keyhothis,$value);
            if($score){
                $redis->zincrby($keyhothis,1,$value);
            }else $redis->zadd($keyhothis,1,$value);
        }else{
           $data['historysearch'] = $redis->lrange($keyhis,0,7);
           $data['hotsearch']=$redis->zrevrange($keyhothis,0,7);
           return $data;
        }                    
    }
    
    //响应格式
    public function FormatJson($info){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'message' =>$info,
        ];
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
    //列表页
    public function actionView($id=null){
        //$model=new DataManageViewForm;
        if((yii::$app->request->get('code') && yii::$app->request->get('type')) || yii::$app->request->get('search') ){
            $get=yii::$app->request->get();
            if(isset($get['search'])){
                $uid=\yii::$app->view->params['uid'];
                $historyKey=$this->userHistoryPrefix.$uid;
                $hotHistoryKey=$this->hotHistoryPrefix;
                $this->getHistorySearch($historyKey,$hotHistoryKey,$get['search']);         
            }           
        }else $get=null; 
        //$data=$model->getIsTopInfo($get);        
        return $this->render('view',[
            'get'=>$get,
            //'data'=>$data['posts'],
            //'pagination'=>$data['pagination'],
        ]);
    }

    //清除历史记录
    public function actionClearhis(){
        if(yii::$app->request->isAjax){
            $type=yii::$app->request->post('type');
            $uid=\yii::$app->view->params['uid'];
            $redis = Yii::$app->redis;
            $key=$this->userHistoryPrefix.$uid;
            if($redis->llen($key)){
                $redis->ltrim($key,1,0);
                $result=1;
            }else  $result=0;
            return $this->FormatJson($result);

        }else throw new NotFoundHttpException('您的请求无效.');
    }
     //上拉加载数据
    public function records($course){
        $page = yii::$app->request->get('page');
        if($page){
            if((yii::$app->request->get('code') && yii::$app->request->get('type')) || yii::$app->request->get('search') ){
                $get=yii::$app->request->get();
            }else $get=null;
            $model=$this->factory($this->modelName);
            $data= $model->getRecords($page,$get,$course);
            return $this->FormatJson($data);
        }throw new NotFoundHttpException("您的请求无效");
    }
     //详情页
    public function actionDataDetail($dataid=null){
        if(!isset($dataid)){
             throw new NotFoundHttpException('您的请求缺少参数.');
        }
        $this->historyView(yii::$app->request->get('unique'));
        $model=$this->factory($this->modelName);
        $uid=\yii::$app->view->params['uid'];
        $data=$model->getDetailInfo($dataid,$uid); 
        //权限认证
        if($this->isAllowView($data['model']->view_level,$uid)==0){
            $memberLevel=$this->getMemberLevel($data['model']->view_level);
            echo "<script>alert('查看该视频需要会员等级为【".$memberLevel."】');window.history.go(-1);</script>";
        }else{
            return $this->render('data-detail',[
                'model' => $data['model'],
                'comment' => $data['comment'],
                'isCollect'=>$data['isCollect']
           ]);
        }
 

    }
    public function getMemberLevel($viewLevel){
        $data=[
            0=>'游客',
            1=>'注册会员',
            2=>'银牌会员',
            3=>'金牌会员',
        ];
        return $data[$viewLevel];
    }
    
    public function isAllowView($viewLevel,$uid){
        $model =User::findOne($uid);
        $userLevel=$this->getUserLevel($model);
        return ($userLevel>=$viewLevel) ? 1 : 0;      
    }
    //提交评论
    public function actionSubcomment(){
        $model=$this->factory($this->modelName);
        if(yii::$app->request->isAjax){
           $uid=\yii::$app->view->params['uid'];
           $posts= yii::$app->request->post();
           $posts['uid']=$uid;
           $result=$model->subComment($posts);
           return $this->FormatJson($result);
        }
    }
    //收藏或者取消收藏
    public function actionToggleCollect(){
        $model=$this->factory($this->modelName);
        if(yii::$app->request->isAjax){
           $uid=\yii::$app->view->params['uid'];
           $posts= yii::$app->request->post();
           $posts['uid']=$uid;
           $result=$model->toggleCollect($posts);
           return $this->FormatJson($result);
        }
    }
    
    //搜索
    public function actionSearch(){
        $uid=\yii::$app->view->params['uid'];
        $historyKey=$this->userHistoryPrefix.$uid;
        $hotHistoryKey=$this->hotHistoryPrefix;
        $history= $this->getHistorySearch($historyKey,$hotHistoryKey);
        return $this->render('search',[
            'history'=>$history
        ]);
    }
}
