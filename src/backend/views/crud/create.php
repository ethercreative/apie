<?php
use yii\helpers\Html;
?>

<div class="row">
    <div class="col-md-12">
        <h1>Create <?= Yii::$app->controller->name ?></h1>

        <hr>

        <?= $this->render('_form', ['model' => $model, 'additional' => isset($additional) ? $additional : null]) ?>
    </div>
</div>
