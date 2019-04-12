<?php
/* @var $this \yii\web\View */
/* @var $content string */
/* @var $service string */
/* @var $title string */
/* @var $product \app\models\Product */
?>
<h1><?= $title ?></h1>
<p><?= $content ?></p>
<p><?=$service?></p>

<?= \yii\widgets\DetailView::widget(['model' => $product])?>