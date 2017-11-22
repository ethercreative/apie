<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

if (empty($options['text_type']) && $options['type'] === 'input')
    $options['text_type'] = 'text';

if (!empty($options['text_type']))
{
    if (trim($options['text_type'],'\\') === 'kartik\select2\Select2')
    {
        // $options['options']['initValueText'] = $model->{str_replace('_id', '', $name)}->name;
    }

    if (empty($options['type']))
        $options['type'] = 'input';

    $field = $form->field($model, $name)->{$options['type']}($options['text_type'], ArrayHelper::getValue($options, 'options', []));
}
else
{
    switch ($options['type'])
    {
        case 'checkboxList':
            $options['options']['item'] = function($index, $label, $name, $checked, $value) use ($model)
            {
                $options = [
                    'label' => $label,
                    'value' => $value,
                ];

                return Html::checkbox($name, $checked, $options) . '<br>';
            };
            break;

        case 'fileInput':
            $files = ArrayHelper::getValue($model, str_replace(['[', ']'], ['.', ''], $name), []);

            if (!is_array($files))
                $files = [];

            $files = array_filter($files);

            $options['options']['value'] = '';

            if (!empty($files))
            {
                $options['hint'] = [];

                foreach ($files as $key => $file)
                {
                    $rowName = join('-', [$model->formName(), str_replace(['[', ']'], ['-', ''], $name), $key]);

                    foreach ($file as $k => $v)
                    {
                        // die('<pre>'.print_r([$name, $key, $k, $v], 1).'</pre>');
                        echo $form->field($model, $name . "[{$key}][{$k}]", ['options' => ['class' => $rowName]])->hiddenInput(['value' => $v])->label(false);
                    }

                    $options['hint'][] = '<div>' . ArrayHelper::getValue($file, 'name') . ' ' . Html::a('<i class="glyphicon glyphicon-download"></i>', ['storage/download', 'file' => $file['filename']], ['class' => 'btn btn-link btn-xs', 'download' => true]) . ' ' . Html::a('&times;', '#', ['class' => 'btn btn-xs btn-danger', 'onclick' => '$(\'.' . $rowName . '\').remove();$(this).parent().remove();return false;']) . '</div>';
                }
                // $options['hint'] = join('<br>', array_keys(ArrayHelper::index($files, 'name')));
            }

            if (!empty($options['options']['multiple']) && $options['options']['multiple'])
                $name .= '[]';

            break;
    }

    if (!empty($options['data']))
        $field = $form->field($model, $name)->{$options['type']}($options['data'], ArrayHelper::getValue($options, 'options', []));
    else
        $field = $form->field($model, $name)->{$options['type']}(ArrayHelper::getValue($options, 'options', []));
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

if (!empty($options['label']))
    $field->label($options['label']);

if (!empty($options['hint']))
    $field->hint(is_array($options['hint']) ? join('', $options['hint']) : $options['hint']);

echo $field;
