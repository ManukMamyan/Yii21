<?php

namespace app\controllers;

use app\models\Task;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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

    public function actionTest()
    {
        //4а) Создание записи в таблице user;

        $user = new User();

        $user->username = 'Karpov';
        $user->password_hash = '$2y$10$bYqSoHwI/WSrN2npSPXKJ.HSHMFUhxpNHkRPZRO5ooZnSjYYD9Xge';
        $user->auth_key = 'some_auth_key_4';
        $user->creator_id = 2;
        $user->updater_id = 1;
        $user->created_at = 1555443750;
        $user->updated_at = 1555493750;
        $user->save();

        //4)б Создать три связаные (с записью в user) запиcи в task, используя метод link();
        $user1 = User::findOne(1);

        $task1 = new Task();
        $task2 = new Task();
        $task3 = new Task();

        $task1->title = 'Task6';
        $task1->description = 'Some Task6';
        $task1->updater_id = 3;
        $task1->created_at = time();
        $task1->updated_at = time();
        $task1->link(Task::RELATION_CREATOR, $user1);

        $task2->title = 'Task7';
        $task2->description = 'Some Task7';
        $task2->updater_id = 2;
        $task2->created_at = time();
        $task2->updated_at = time();
        $task2->link(Task::RELATION_CREATOR, $user1);

        $task3->title = 'Task8';
        $task3->description = 'Some Task8';
        $task3->updater_id = 1;
        $task3->created_at = time();
        $task3->updated_at = time();
        $task3->link(Task::RELATION_CREATOR, $user1);

        //4в) Жадная загрузка без JOIN;
        $users = User::find()->with(USER::RELATION_TASKS_CREATOR_ID)->asArray()->all();

        //4г) Жадная загрузка c JOIN;
        $users1 = User::find()->joinWith(USER::RELATION_TASKS_CREATOR_ID)->asArray()->all();

        //5
        //$task = Task::findOne(1);
        //_end($task->getAccessedUsers()->all());
        $task = Task::findOne(2);
        $user = User::findOne(4);

        $task ->link(Task::RELATION_ACCESSED_USERS, $user);

    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
