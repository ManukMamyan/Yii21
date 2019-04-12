<?php

namespace app\controllers;

use app\components\TestService;
use app\models\Product;
use yii\helpers\VarDumper;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        $service = \Yii::$app->test->run();

        $product = Product::findOne(4);

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
       \Yii::info('success', 'pay');

        return $this->render('index', [
            'title' => 'Yii2 Framework',
            'content' => 'Welcome to GeekBrains',
            'service' => $service,
            'product' => $product,
        ]);
    }
}