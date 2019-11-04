<?php

namespace backend\controllers;

use Yii;
use common\models\SuccessExample;
use common\models\SuccessExampleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;

/**
 * SuccessExampleController implements the CRUD actions for SuccessExample model.
 */
class SuccessExampleController extends BaseController
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
     * Lists all SuccessExample models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SuccessExampleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SuccessExample model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewSuccessExample')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else throw new ForbiddenHttpException('对不起，您没有相关权限!');
    }

    /**
     * Creates a new SuccessExample model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createSuccessExample')) {
            $model = new SuccessExample();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }else throw new ForbiddenHttpException('对不起，您没有相关权限!');
    }

    /**
     * Updates an existing SuccessExample model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updateSuccessExample')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }else throw new ForbiddenHttpException('对不起，您没有相关权限!');
    }

    /**
     * Deletes an existing SuccessExample model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteSuccessExample')) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else throw new ForbiddenHttpException('对不起，您没有相关权限!');
    }

    /**
     * Finds the SuccessExample model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SuccessExample the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SuccessExample::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('这个请求不存在.');
    }
    
    
}
