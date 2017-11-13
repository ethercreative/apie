<?php
use yii\bootstrap\Tabs;

if ($tabs && $model)
{
    function placeholder($input, $model)
    {
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

    echo Tabs::widget([
        'items' => $tabs,
    ]);

    echo '<hr>';
}

?>
