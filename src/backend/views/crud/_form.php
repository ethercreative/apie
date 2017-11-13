<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

if (empty($fields))
    $fields = Yii::$app->controller->getFields();

$modals = [];
$endForm = true;

if (!isset($outputModals))
    $outputModals = true;

if (empty($form))
    $form = ActiveForm::begin();
else
    $endForm = false;

if ((!isset($summary) || $summary) && $model->hasErrors())
    echo $form->errorSummary($model) . '<hr>';

foreach ($fields as $name => $options)
{
    if (!empty($options['modal']))
    {
        if ($outputModals)
            $modals[$name] = $options['modal'];
        else
            Yii::$app->modals->addModal($name, $options['modal']);
    }

    if ($options === 'hr')
    {
        echo '<hr>';
        continue;
    }

    if (is_string($options))
    {
        $header = substr_count($options, '#');

        if ($header)
            echo Html::tag('h' . $header, trim(str_replace('#', '', $options)));
        else
            echo $options;

        continue;
    }

    if (is_int($name))
    {
        $width = floor(12 / count($options));
        echo '<div class="row">';
        foreach ($options as $key => $value)
        {
            if (!empty($value['modal']))
            {
                if ($outputModals)
                    $modals[$key] = $value['modal'];
                else
                    Yii::$app->modals->addModal($key, $value['modal']);
            }

            if (!empty($prepend))
                $key = $prepend . '[' . $key . ']';

            echo '<div class="col-md-' . $width . '">';
            echo $this->render('_field', ['name' => $key, 'options' => $value, 'model' => $model, 'form' => $form]);
            echo '</div>';
        }
        echo '</div>';
    }
    else
    {
        if (!empty($prepend))
            $name = $prepend . '[' . $name . ']';

        echo $this->render('_field', ['name' => $name, 'options' => $options, 'model' => $model, 'form' => $form]);
    }
}

if (!empty($additional))
    echo $additional;

if (!isset($controls) || $controls)
    echo $this->render('_controls', ['model' => $model]);

if ($endForm)
    ActiveForm::end();

if ($outputModals)
    $this->render('_modals', ['modals' => $modals]);
