<?php
use yii\bootstrap\Tabs;

if ($tabs && $model)
{
    function placeholder($input, $model)
    {
        preg_match_all('/{{([\w\d_]+)}}/', $input, $matches);
        $attributes = array_combine($matches[0], $matches[1]);

        foreach ($attributes as $key => $attribute) {
            $input = str_replace($key, $model->{$attribute}, $input);
        }

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
