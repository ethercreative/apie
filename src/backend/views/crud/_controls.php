<?php
use yii\helpers\Html;
?>

<hr>

<div class="form-group">
    <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary']) ?>
    <?= $model->isNewRecord ? Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save and add another', ['class' => 'btn btn-primary', 'name' => 'additional', 'value' => 'yes']) : null ?>
    <?= !$model->isNewRecord ? Html::a('<i class="glyphicon glyphicon-compressed"></i> Archive', ['archive', 'id' => $model->id], ['class' => 'btn btn-danger pull-right']) : null ?>
</div>
