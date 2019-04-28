<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'creator_id',
            'updater_id',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    </br>
    </br>
    </br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Shared Users',
                'value' => function (app\models\TaskUser $model) {
                    return  $model->getUser()->one()->username;
                }],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{unshare}',
                'buttons' =>
                    [
                        'unshare' => function ($url, $model, $key) {
                            $icon = \yii\bootstrap\Html::icon('remove-sign');
                            return Html::a($icon, ['task-user/delete', 'taskUserId' => $model->id],
                                [
                                    'title' => 'close access',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to close access to this task?',
                                        'method' => 'post',
                                    ],
                                ]);
                        },
                    ],
            ],
        ],
        'summary' => false,
    ]); ?>

</div>
