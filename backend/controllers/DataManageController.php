<?php

namespace backend\controllers;

use Yii;
use common\models\DataManage;
use common\models\DataManageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\controllers\BaseController;

/**
 * DataManageController implements the CRUD actions for DataManage model.
 */
class DataManageController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DataManage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataManageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);                   
    }

    /**
     * Displays a single DataManage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewDataManage')) {
             return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else throw new ForbiddenHttpException('对不起，您没有相关权限!');
           
    }

    /**
     * Creates a new DataManage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createDataManage')) {
            $model = new DataManage();
            if ($model->load(Yii::$app->request->post()) ) {
                $model->videoFile = UploadedFile::getInstance($model, 'videoFile'); 
                if ($model->upload() && $model->save()){
                    // 文件上传成功
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }else throw new ForbiddenHttpException('对不起，您没有相关权限!');
    }
    
    public function actionUpload()
    {
        $model = new DataManage();       
        if ($model->load(Yii::$app->request->post()) ) {
            $model->videoFile = UploadedFile::getInstance($model, 'videoFile');         
            if ($model->upload() && $model->save()) {
                // 文件上传成功
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing DataManage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updateDataManage')) {
            $model = $this->findModel($id);        
            if ($model->load(Yii::$app->request->post()) ) {
                $model->videoFile = UploadedFile::getInstance($model, 'videoFile'); 
                if ($model->upload() && $model->save()){
                    // 文件上传成功
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }
            //  if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            //}
            return $this->render('update', [
                'model' => $model,
            ]);
        }else throw new ForbiddenHttpException('对不起，您没有相关权限!');
            
    }

    /**
     * Deletes an existing DataManage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteDataManage')) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else throw new ForbiddenHttpException('对不起，您没有相关权限!');
    }

    /**
     * Finds the DataManage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataManage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataManage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
   
}
