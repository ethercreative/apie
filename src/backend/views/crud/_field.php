<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

if ($options['text_type'])
{
    if ($options['text_type'] === 'kartik\select2\Select2')
    {
        $options['options']['initValueText'] = 'hello';
    }

    $field = $form->field($model, $name)->{$options['type']}($options['text_type'], $options['options']);
}
else
{
    $field = $form->field($model, $name)->{$options['type']}($options['options']);
}

// create modal, if exists, and add link to hint
if (!empty($options['modal']) && !ArrayHelper::getValue($options, 'modal.disabled'))
{
    $link = Html::a($options['modal']['label'], '#', ['onclick' => '$(\'#modal-button-'.$name.'\').click()']);

    if (!$options['hint'])
        $options['hint'] = $link;
    else
        $options['hint'] .= $link;

    $modals[$name] = $options['modal'];
}

if (!empty($options['hint']))
    $field->hint($options['hint']);

echo $field;
