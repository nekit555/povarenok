<?php

namespace common\modules\povarenok\controllers;

use common\modules\povarenok\models\Ingredients;
use Yii;
use common\modules\povarenok\models\Dishes;
use common\modules\povarenok\models\DishesSearch;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DishesController implements the CRUD actions for Dishes model.
 */
class DishesController extends Controller
{
    /**
     * @inheritdoc
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

    public function beforeAction($action)
    {

        if (!parent::beforeAction($action))
        {
            return false;
        }

        if (!Yii::$app->user->isGuest)
        {
            return true;
        } else {
            Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
            //для перестраховки вернем false
            return false;
        }
    }

    /**
     * Lists all Dishes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DishesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Dishes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dishes();
        $model->loadDefaultValues();
        $data = Ingredients::find()->select(['name', 'id'])->indexBy('id')->column();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($model->save() ) {
                Yii::$app->getSession()->setFlash('success', 'Блюдо успешно сохранено');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Ошибка сохранения блюда');
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'data' => $data
            ]);
        }
    }

    /**
     * Updates an existing Dishes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = Ingredients::find()->select(['name', 'id'])->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save() ) {
                Yii::$app->getSession()->setFlash('success', 'Блюдо успешно сохранено');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Ошибка сохранения блюда');
            }
            return $this->redirect(['index']);

        } else {
            return $this->render('update', [
                'model' => $model,
                'data' => $data
            ]);
        }
    }

    /**
     * Deletes an existing Dishes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dishes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dishes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dishes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
