<?php
use yii\helpers\Html;
?>

<h1>Viewing <?= Yii::$app->controller->name ?>: <?= $model->id; ?> <span class="pull-right">
    <?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
    <?= Html::a('<i class="glyphicon glyphicon-compressed"></i> Archive', ['archive', 'id' => $model->id], ['class' => 'btn btn-danger']); ?>
</span></h1>

<hr>

<h3>Attributes</h3>

<table class="table table-striped table-hover">
    <tbody>
        <?php foreach ($model->attributes as $key => $value): ?>
        <tr>
            <td><strong><?= $model->getAttributeLabel($key); ?></strong></td>
            <td><?php

            if ($value InstanceOf \DateTime)
                echo $value->format('r');
            elseif (is_array($value))
                echo '<pre>' . print_r($value, 1) . '</pre>';
            else
                echo $value;

            ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
