<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

$modals = [];

$form = ActiveForm::begin();

echo Html::errorSummary($model);

foreach (Yii::$app->controller->getFields() as $name => $options)
{
    if ($options === 'hr')
    {
        echo '<hr>';
        continue;
    }

    if (is_string($options))
    {
        echo $options;
        continue;
    }

    if (is_int($name))
    {
        $width = 12 / count($options);
        echo '<div class="row">';
        foreach ($options as $key => $value)
        {
            echo '<div class="col-md-' . $width . '">';
            echo $this->render('_field', ['name' => $key, 'options' => $value, 'model' => $model, 'form' => $form]);
            echo '</div>';
        }
        echo '</div>';
    }
    else
    {
        echo $this->render('_field', ['name' => $name, 'options' => $options, 'model' => $model, 'form' => $form]);
    }
}
?>

<hr>

<?= $additional ?>

<div class="form-group">
    <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary']) ?>
    <?= $model->isNewRecord ? Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save and add another', ['class' => 'btn btn-primary', 'name' => 'additional', 'value' => 'yes']) : null ?>
    <?= !$model->isNewRecord ? Html::a('<i class="glyphicon glyphicon-compressed"></i> Archive', ['archive', 'id' => $model->id], ['class' => 'btn btn-danger pull-right']) : null ?>
</div>

<?php ActiveForm::end(); ?>

<?php

foreach ($modals as $key => $modal)
{
    Modal::begin([
        'header' => "<h2>{$modal['title']}</h2>",
        'toggleButton' => ['label' => 'click me', 'class' => 'hide', 'id' => 'modal-button-' . $key],
    ]);

    if (strpos($modal['content'], '@') !== false)
    {
        Pjax::begin();

        echo $this->render($modal['content'], [
            'model' => new $modal['model'],
        ]);

        Pjax::end();
    }
    else
    {

    }

    Modal::end();
}

?>
