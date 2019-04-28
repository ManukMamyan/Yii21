<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    public $defaultAction = 'my';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionMy()
    {
        $query = Task::find()->byCreator(\Yii::$app->user->id);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('my', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionShared()
    {
        $query = Task::find()
            ->byCreator(\Yii::$app->user->id)
            ->innerJoinWith(Task::RELATION_TASK_USERS);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('shared', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionAccessed()
    {
        $query = Task::find()->innerJoinWith(Task::RELATION_TASK_USERS)
            ->where(['user_id' => \Yii::$app->user->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('accessed', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (!$model ||
            ($model->creator_id !== \Yii::$app->user->id && !in_array(\Yii::$app->user->id, $model->getTaskUsers()->select('user_id')->column()))) {
            throw new ForbiddenHttpException();
        }

        if ($model->creator_id !== \Yii::$app->user->id) {
            return $this->render('view', [
                'model' => $model,
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => $model->getTaskUsers()
            ]);

            return $this->render('viewmy', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }


    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Task was created successfully');
            return $this->redirect(['my']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!$model || $model->creator_id !== \Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Task was updated successfully');
            return $this->redirect(['my']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (!$model || $model->creator_id !== \Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Task was deleted successfully');

        return $this->redirect(['my']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
