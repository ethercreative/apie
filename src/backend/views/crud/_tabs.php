<?php
use yii\bootstrap\Tabs;

if ($tabs && $model)
{
    // die('<pre>'.print_r([$tabs, $model->attributes], 1).'</pre>');

    function placeholder($input, $model)
    {
        if (is_array($input))
            die('<pre>'.print_r($input, 1).'</pre>');

        if (substr($input, 0, 2) == '{{' && substr($input, -2) == '}}')
            $input = $model->{str_replace(['{', '}'], '', $input)};

        return $input;
    }

    foreach ($tabs as &$tab)
    {
        if (empty($tab['url']) || !is_array($tab['url'])) continue;

        foreach ($tab['url'] as &$part)
        {
            if (is_array($part))
            {
                foreach ($part as &$attribute)
                    $attribute = placeholder($attribute, $model);
            }
            else
            {
                $part = placeholder($part, $model);
            }
        }
    }

    // die('<pre>'.print_r([$tabs, $model->attributes, $model->className()], 1).'</pre>');

    echo Tabs::widget([
        'items' => $tabs,
    ]);

    echo '<hr>';
}

?>
