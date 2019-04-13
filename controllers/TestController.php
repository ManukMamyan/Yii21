<?php

namespace app\controllers;

use app\components\TestService;
use app\models\Product;
use yii\db\Query;
use yii\helpers\VarDumper;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        $service = \Yii::$app->test->run();

        $product = Product::findOne(4);
        //$product = new Product();
        //$data = \Yii::$app->db->createCommand('SELECT * FROM {{product}} WHERE id=:id', [':id' => $id])->queryAll();
        //$data = \Yii::$app->db->createCommand()->update('product', ['price' => 999], 'id = :id', [':id' => $id]);
        //$data = \Yii::$app->db->createCommand()->insert('product', ['price' => 999], 'id = :id', [':id' => $id]);
        //$data = \Yii::$app->db->createCommand()->delete('product');
        /*        $data = \Yii::$app->db->createCommand()->batchInsert('product', ['price', 'name', 'created_at'], [
                    [999, 'name1'],
                    [999, 'name2'],
                    [999, 'name3'],
                ]);*/
        //$data->execute();
        $id = 2;
        $query = new Query();
        $data = $query->from('product')
            ->select(['id', 'cost' => 'price'])
            ->where(['id' => 1, 'price' => 999])
            ->all();
        _log($data);
        //_end($data);

        /*        $product = new Product();
                $data = [
                    'id' => 15,
                    'name' => 'bike',
                    'price' => '15000$',
                    'category' => 'vehicle'
                ];
                $product->name = ' <p>Book</p> ';
                $product->price = 999;
                $product->created_at = 1547000;

                $product->setAttributes($data);

                $product->validate();
                //$product->getErrors();
                return VarDumper::dumpAsString($product->getAttributes(), 4, true);*/
        //\Yii::info('success', 'pay');

        return $this->render('index', [
            'title' => 'Yii2 Framework',
            'content' => 'Welcome to GeekBrains',
            'service' => $service,
            'product' => $product,
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
        $query = new Query();
        $query1 = new Query();
        $query2 = new Query();
        $query3 = new Query();

        $data = $query->from('user')
            ->where(['id' => 1])
            ->all();

        $data1 = $query1->from('user')
            ->where(['>', 'id', '1'])
            ->orderBy(['username' => SORT_DESC])
            ->all();

        $data2 = $query2->from('user')->count('*');

        $data3 = $query3->from('task')
            ->innerJoin('user', 'user.id = task.creator_id')
            ->all();


        //_end($data);
        //_end($data1);
        _end($data3);
    }
}
