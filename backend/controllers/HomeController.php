<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use backend\controllers\BaseController;
use common\models\DataManage;
use common\models\User;
use common\models\SuccessExample;
use common\models\Comment;
use common\models\GiveLike; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class HomeController extends BaseController{
    public function actionIndex(){
        if (\Yii::$app->user->can('viewHome')) {
            //最新用户
            $modelUser=User::find()->select('*')->orderBy('created_at DESC')->limit(10)->asArray()->all();
            if(!$modelUser) $modelUser=[];
            //最新评论
            $modelComment=Comment::find()->select('comment.*,u.name,u.username,s.title')
                    ->join('LEFT JOIN','user u','u.id=comment.u_id')
                    ->join('LEFT JOIN','success_example s','s.unique_key=comment.unique_key')
                    ->orderBy('ctime DESC')->limit(10)->asArray()->all();
            if($modelComment){
                foreach($modelComment  as  $key=>$v){
                     if(!$v['title']){                   
                            $modelDatamanage=  DataManage::find()->where('unique_key=:unique_key')->addParams([':unique_key'=>$v['unique_key']])->one();
                            $modelComment[$key]['title']=$modelDatamanage->title;                     
                     }
                }

            }else $modelComment=[];
            // 返回一个Post实例的数组
            // 用户概况
            $user['count']= User::find()->count();
            $user['isvipCount']= User::find()->where(['is_vip'=>1])->count();
            $user['notVipCount']=$user['count']-$user['isvipCount'];
            $user['lastWeekAddUser']= User::find()->where(['>','created_at',time()-86400*7])->count();
            $user['lastMonthAddUser']= User::find()->where(['>','created_at',time()-86400*30])->count();
            $user['lastWeekLoginUser']= User::find()->where(['>','last_login_time',time()-86400*7])->count();
            $user['lastMonthLoginUser']= User::find()->where(['>','last_login_time',time()-86400*30])->count();      
            $SuccessExample=SuccessExample::find()->select('sum(page_view)')->asArray()->one();
            $DataManage=DataManage::find()->select('sum(page_view)')->asArray()->one();
            $product['pageViewCount']=$SuccessExample['sum(page_view)']+$DataManage['sum(page_view)'];
            $product['giveLikeCount']=GiveLike::find()->count();
            $product['commentCount']=Comment::find()->count();
            return $this->render('index', [
                'modelUser' => $modelUser,
                'modelComment' =>  $modelComment,
                'user'=>$user,
                'product'=>$product
                ]);
        }else throw new ForbiddenHttpException('对不起，您没有相关权限!');
    }
}
