<?php
namespace backend\controllers;

use Yii;
use common\models\Adminuser; 
use common\models\AdminuserSearch;
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
use common\models\AuthItem;
use common\models\AuthAssignment;
use backend\models\ChangePass;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AdminuserController extends BaseController{
    /**
    * {@inheritdoc}
    */
   public function behaviors(){
       return [
           'verbs' => [
               'class' => VerbFilter::className(),
               'actions' => [
                   'delete' => ['POST'],
               ],
           ],
       ];
   }
   public function beforeAction($action){
        if (\Yii::$app->user->can('viewAdminuser')) {
            return true;
        }else throw new ForbiddenHttpException('对不起，您没有相关权限!');
   }
   /**
    * Lists all Adminuser models.
    * @return mixed
    */
   public function actionIndex(){
       $searchModel = new AdminuserSearch();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       return $this->render('index', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
       ]);
    }
   /**
    * Displays a single Adminuser model.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionView($id){
       return $this->render('view', [
           'model' => $this->findModel($id),
       ]);
    }
   /**
    * Creates a new Adminuser model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionCreate(){
       $model = new Adminuser();
       if ($model->load(Yii::$app->request->post())) {
           if($id=$model->add()){
               return $this->redirect(['index']);
           }           
       }
       return $this->render('create', [
           'model' => $model,
       ]);
    } 
   /** 
    * Updates an existing Adminuser model. 
    * If update is successful, the browser will be redirected to the 'view' page. 
    * @param integer $id 
    * @return mixed 
    * @throws NotFoundHttpException if the model cannot be found 
    */ 
    public function actionUpdate($id){ 
       $model = $this->findModel($id); 
 
       if ($model->load(Yii::$app->request->post()) && $model->change($id)) { 
           return $this->redirect(['index']); 
       } 
 
       return $this->render('update', [ 
           'model' => $model, 
       ]); 
    } 
 
   /** 
    * Deletes an existing Adminuser model. 
    * If deletion is successful, the browser will be redirected to the 'index' page. 
    * @param integer $id 
    * @return mixed 
    * @throws NotFoundHttpException if the model cannot be found 
    */ 
    public function actionDelete($id){ 
       $this->findModel($id)->delete(); 
 
       return $this->redirect(['index']); 
    } 
 
   /** 
    * Finds the Adminuser model based on its primary key value. 
    * If the model is not found, a 404 HTTP exception will be thrown. 
    * @param integer $id 
    * @return Adminuser the loaded model 
    * @throws NotFoundHttpException if the model cannot be found 
    */ 
    protected function findModel($id){ 
       if (($model = Adminuser::findOne($id)) !== null) { 
           return $model; 
       } 
 
       throw new NotFoundHttpException('The requested page does not exist.'); 
    }
    public function actionChangepass(){
        $model = new ChangePass();
        if ($model->load(Yii::$app->request->post()) && $model->change()) {
            Yii::$app->session->setFlash('成功', '新密码设置成功.');
            return $this->goHome();
        }

        return $this->render('changepass', [
            'model' => $model,
            'uid'=>yii::$app->user->id
        ]);
    }
    
    public function actionPrivilege($id){
        //step1.找出所有权限，提供给checkboxlist
        $allPrivileges= AuthItem::find()->select(['name','description'])
                ->where(['type'=>1])->all();
        foreach($allPrivileges as $pri){
            $allPrivilegesArray[$pri->name]=$pri->description;
        }
        //step2.当前用户的权限
        $AuthAssignments=  AuthAssignment::find()->select(['item_name'])
                ->where(['user_id'=>$id])->all();
        $AuthAssignmentsArray=array();
        foreach($AuthAssignments as $AuthAssignment){
            array_push($AuthAssignmentsArray,$AuthAssignment->item_name);
        }
        //step3. 从表单提交的数据，来更新AuthAssignment表，从而用户的角色发生变化
        if(isset($_POST['newPri'])){
           AuthAssignment::deleteAll('user_id=:id',[':id'=>$id]); 
           $newPri = $_POST['newPri'];
           $arrlength=count($newPri);
           for($x=0;$x<$arrlength;$x++){
               $aPri=new AuthAssignment();
               $aPri->item_name = $newPri[$x];
               $aPri->user_id=$id;
               $aPri->created_at=time();
               $aPri->save(false);
           }
           return $this->redirect(['index']);
        }
        //step4.渲染checkBoxList表单
        return $this->render('privilege',[
            'id'=>$id,
            'AuthAssignmentsArray'=>$AuthAssignmentsArray,
            'allPrivilegesArray'=>$allPrivilegesArray,
            'model'=>Adminuser::findOne($id)
        ]);
    }
}

