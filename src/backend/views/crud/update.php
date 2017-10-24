<?php
use yii\helpers\Html;
?>

<div class="row">
    <div class="col-md-12">
        <h1>Update <?= Yii::$app->controller->name ?></h1>

        <hr>

        <?= Yii::$app->controller->renderPartial('@apie/backend/views/crud/_tabs', ['tabs' => Yii::$app->controller->getTab('update'), 'model' => $model]); ?>

        <?= $this->render('_form', ['model' => $model, 'additional' => isset($additional) ? $additional : null]) ?>
    </div>
</div>
