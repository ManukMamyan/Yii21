<?php

namespace app\controllers;

use app\components\TestService;
use app\models\Product;
use app\models\User;
use yii\db\Query;
use yii\helpers\VarDumper;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        $users1 = User::find()->joinWith(User::RELATION_TASKS_CREATOR_ID)->asArray()->all();

        $title = "Hello World!!";
        return $this->render('index', [
            'title' => $title,
            'users' => $users1,
        ]);
    }

    public function actionInsert()
    {
        /*        \Yii::$app->db->createCommand()->insert('user',
                    [
                        'username' => 'Ivanov',
                        'password_hash' => '$2y$10$bYqSoHwI/WSrN2npSPXKJ.HSHMFUhxpNHkRPZRO5ooZnSjYYD9Xge',
                        'auth_key' => 'some_auth_key_1',
                        'creator_id' => 1,
                        'updater_id' => 2,
                        'created_at' => 1555143750,
                        'updated_at' => 1555143750,
                    ])->execute();

                \Yii::$app->db->createCommand()->insert('user',
                    [
                        'username' => 'Petrov',
                        'password_hash' => '$2y$10$bYqSoHwI/WSrN2npSPXKJ.HSHMFUhxpNHkRPZRO5ooZnSjYYD9Xge',
                        'auth_key' => 'some_auth_key_2',
                        'creator_id' => 3,
                        'updater_id' => 1,
                        'created_at' => 1555144210,
                        'updated_at' => 1555144220,
                    ])->execute();

                \Yii::$app->db->createCommand()->insert('user',
                    [
                        'username' => 'Sidorov',
                        'password_hash' => '$2y$10$bYqSoHwI/WSrN2npSPXKJ.HSHMFUhxpNHkRPZRO5ooZnSjYYD9Xge',
                        'auth_key' => 'some_auth_key_3',
                        'creator_id' => 2,
                        'updater_id' => 2,
                        'created_at' => 1555164210,
                        'updated_at' => 1555174220,
                    ])->execute();*/

        \Yii::$app->db->createCommand()->batchInsert('task',
            [
                'title',
                'description',
                'creator_id',
                'updater_id',
                'created_at',
                'updated_at'
            ],


            [
                ['Task1', 'someTask1', 1, 2, 1555144210, 1555144210],
                ['Task2', 'someTask2', 2, 3, 1555144210, 1555144210],
                ['Task3', 'someTask3', 3, 1, 1555144210, 1555144210],
            ])->execute();

    }

    public function actionSelect()
    {
        $data = (new Query())->from('user')
            ->where(['id' => 1])
            ->all();

        $data1 = (new Query())->from('user')
            ->where(['>', 'id', '1'])
            ->orderBy(['username' => SORT_DESC])
            ->all();

        $data2 = (new Query())->from('user')->count('');

        $data3 = (new Query())->from('task')
            ->innerJoin('user', 'user.id = task.creator_id')
            ->all();


    }
}
